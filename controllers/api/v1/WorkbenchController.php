<?php

namespace app\controllers\api\v1;

use app\helpers\AttributeParser;
use app\helpers\AttributeSaver;
use app\helpers\ImageStats;
use app\models\pure\Classification;
use app\models\pure\Image;
use app\models\pure\ImageCreator;
use app\models\pure\ShapeType;
use app\models\pure\Testing;
use app\models\pure\User;
use app\models\pure\UserConfig;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class WorkbenchController extends Controller

{

    public $enableCsrfValidation = true;

    public $user;

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {


            $this->user = \app\models\pure\User::findOne(["id" => 2]);
            $this->user->login();
        } else {
            $this->user = Yii::$app->user->identity;

        }

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'upload-image' => ['POST'],
                    'save-shapes' => ['POST'],

                ],
            ],
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ]
        ];

    }


    public function actionReceiveImages()
    {
        $result = [];
        $user = $this->user;
        $users_sql_appender = "";

        if (!$user->isAdmin) {


            $users_sql_appender = " and (image_creator.user_id={$this->user->id} or exists(select user_manager.user_id  from user_manager where image_creator.user_id=user_manager.user_id and user_manager.manager_id={$this->user->id})) ";

        }


        $models = \app\models\pure\Image::findBySql("select image.*,image_creator.user_id as user_id,NULL as testing_id from image
                inner join  image_creator on image_creator.image_id=image.id $users_sql_appender
                 where image.visible=1
                 union all 
             select image.*,image_creator.user_id as user_id, testing_id from image
                inner join  image_creator on image_creator.image_id=image.id $users_sql_appender
                inner join testing_images on  testing_images.image_id=image.id and conclusion_id is not null
                 where image.visible=1
          
             group by image.id,testing_id
            order by user_id,name,testing_id asc ")->all();

        $image_ids = [];

        foreach ($models as $model) {


            $attributes = $model->getAttributes();
            $user = User::findBySql("select * from user
                inner join image_creator on image_creator.user_id=user.id and image_creator.image_id=$model->id")->one();

            $attributes["user_fullname"] = $user->fullname;
            $attributes["name"] = $model->name . ($model->testing_id ? " [" . Testing::findOne($model->testing_id)->name . "] " : null);
            array_push($result, $attributes);

        }

        return ["success" => ["images" => $result]];
    }


    public function actionUploadImage()
    {

        $user = $this->user;
        $model = new Image();

        try {


            if (Yii::$app->request->isPost) {


                if ($model->save()) {
                    $image_creator = new ImageCreator();
                    $image_creator->image_id = $model->id;
                    $image_creator->user_id = $user->id;
                    $image_creator->save();
                    $this->setUserConfig($model);

                } else
                    return ["error" => $model->getFirstErrors()];

                return ["success" => $model->getAttributes()];

            }
            return ["error" => "No image"];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }

    }


    public function actionGetImageStatistics()
    {
        $request = Yii::$app->request->get();

        try {
            if (isset($request["id"]) && $request["id"] && ($image = $this->findModel($request["id"]))) {

                $testing_id = null;
                if (isset($request["testing_id"]) && $request["testing_id"]) {
                    $testing_id = $request["testing_id"];

                }


                $imageStats = new ImageStats($image, $testing_id);
                return ["success" => ["shapes" => $imageStats->init()]];


            }
        } catch (\Exception $e) {


            return ["error" => $e->getMessage()];
        }
    }


    public function actionGetShapesByImage()
    {


        $request = Yii::$app->request->get();

        try {
            if (isset($request["id"]) && $request["id"] && ($image = $this->findModel($request["id"]))) {

                $testing_id = null;
                if (isset($request["testing_id"]) && $request["testing_id"])
                    $testing_id = $request["testing_id"];
                $attributeParser = new AttributeParser($this->user, $image);
                $attributeParser->testing_id = $testing_id;
                return ["success" => $attributeParser->init()];

            }
        } catch (\Exception $e) {


            return ["error" => $e->getMessage()];
        }


        return ["error" => "Missing id for image id ",
        ];

    }


    public function actionSaveShapes()
    {
        try {
            $request = Yii::$app->getRequest()->getRawBody();

            $request = Json::decode($request)["data"];

        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];

        }
        if (isset($request["image"]) && isset($request["image"]["id"])) {

            $image_id = $request["image"]["id"];
            $testing_id = null;
            if (isset($request["image"]["testing_id"]) && $request["image"]["testing_id"])
                $testing_id = $request["image"]["testing_id"];
            try {
                $image = $this->findModel($image_id);


                $attributeSaver = new AttributeSaver($this->user, $image, $request);
                $attributeSaver->testing_id = $testing_id;
                return ["success" => $attributeSaver->init()];
            } catch (\Exception $e) {
                return ["error" => $e->getMessage()];

            }
        }
        return ["error" => "image id not set" . json_encode($request)];
    }

    public function actionSetUserConfiguration()
    {
        $request_post = Json::decode(Yii::$app->getRequest()->getRawBody());
        if (isset($request_post["data"]) && ($request = $request_post["data"]) && isset($request["UserConfig"]) && is_array($request["UserConfig"])) {

            $array_userConfig = $request["UserConfig"];
            // check if image_id id is set and if the user has permission to set it as his image
            if (isset($array_userConfig["attribute_parser_image_id"]) && $array_userConfig["attribute_parser_image_id"] && ($image = $this->findModel($array_userConfig["attribute_parser_image_id"]))) {
                $testing_id = null;
                if (isset($array_userConfig["image_testing_id"]) && ($array_userConfig["image_testing_id"]))
                    $testing_id = $array_userConfig["image_testing_id"];
                $this->setUserConfig($image, $testing_id);
                return ["success" => ["user_config" => UserConfig::findOne($this->user->id)],
                ];

            }


        }

        return ["error" => "wrong params",
        ];


    }


    private function setUserConfig($image, $image_testing_id = null)
    {
        $userConfig = UserConfig::findOne($this->user->id);
        if (!$userConfig) {
            $userConfig = new UserConfig();
            $userConfig->user_id = $this->user->id;
        }
        $userConfig->attribute_parser_image_id = $image->id;
        $userConfig->image_testing_id = $image_testing_id;
        return $userConfig->save();
    }

    public function actionGetEssentials()
    {
        $result = [];
        $result["classifications"] = Classification::find()->all();
        $result["shape_types"] = ShapeType::find()->all();
        $result["user"] = User::findOne(["id" => $this->user->id]);
        $result["user_configuration"] = UserConfig::findOne(["user_id" => $this->user->id,
        ]);


        return ["success" => $result];
    }


//* @throws NotFoundHttpException if the model cannot be found
    protected function findModel($id)
    {


        $model = null;
        if ($this->user->isAdmin && $model = Image::findBySql("select * from image where id=$id")->one())
            return $model;
        else if (($model = Image::getRestricted($this->user->id, $id)) && $model->visible == 1)
            return $model;

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
