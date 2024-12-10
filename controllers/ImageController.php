<?php

namespace app\controllers;

use app\models\pure\ImageCreator;
use Yii;
use app\models\pure\Image;
use app\models\search\ImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Request;
use yii\web\UploadedFile;

/**
 * ImageController implements the CRUD actions for Image model.
 */
class ImageController extends AuthedController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Image models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Image model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $models = [];

        if (is_array($id)) {
            foreach ($id as $i)
                $models[] = $this->findModel($i);
        } else {
            $models[] = $this->findModel($id);
        }


        return $this->render('view', [
            'model' => $models
        ]);
    }

    /**
     * Creates a new Image model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Image();
        $image_creator = new ImageCreator();
        if ($model->load(Yii::$app->request->post()) && $image_creator->load(Yii::$app->request->post())) {

            $images = UploadedFile::getInstances($model, 'images');
            $size = sizeof($images);
            $saved = 0;

            $ids = [];
            foreach ($images as $key => $image) {
                $image_model = new Image();
                $image_model->visible = $model->visible;
                $image_model->image = $image;
                if ($image_model->save()) {
                    $ids[] = $image_model->id;
                    $image_creator_copy = new ImageCreator();
                    $image_creator_copy->user_id = $image_creator->user_id;
                    $image_creator_copy->image_id = $image_model->id;
                    $image_creator_copy->save();
                    $saved++;
                } else
                    return json_encode($image_model->getErrors());

            }
            if ($saved) {


                if ($size > 1)
                    return $this->redirect(['view', "id" => $ids]);
                else
                    return $this->redirect(['view', "id" => $image_model->id]);
            }


        }

        return $this->render('create', [
            'model' => $model,
            "image_creator" => $image_creator
        ]);
    }


    /**
     * Deletes an existing Image model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $result = Yii::$app->db->createCommand("delete shape from shape 
inner join image_shape on image_shape.shape_id=shape.id and image_id=$id")->execute();
        if ($result)
            $this->findModel($id)->delete();

        return $this->actionOnDelete();
    }

    /**
     * Finds the Image model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return array|\yii\db\ActiveRecord
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\web\ForbiddenHttpException
     */
    protected function findModel($id)
    {
        if ($id)
            if ($this->user->isAdmin && (($model = Image::findOne($id)) !== null)) {
                return $model;
            } else if (($model = Image::getRestricted($this->user->id, $id)) === null)
                $this->forbid();
            else if ($model !== null)
                return $model;


        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
