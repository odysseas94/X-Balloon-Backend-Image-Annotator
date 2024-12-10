<?php

namespace app\controllers\api\v1;

use app\helpers\AIParser\DatasetParser;
use app\helpers\AIParser\ShapesSimplified;
use app\helpers\AttributeSaver;
use app\helpers\Testing\TestingSetParser;
use app\models\pure\AIStatus;
use app\models\pure\Classification;
use app\models\pure\Conclusion;
use app\models\pure\Image;
use app\models\pure\Shape;
use app\models\pure\ShapeType;
use app\models\pure\Testing;
use app\models\pure\TestingImages;
use app\models\pure\TrainingWeights;
use app\models\pure\WeightFile;
use Yii;
use yii\helpers\Json;

class AiController extends \app\controllers\api\v1\BasicController
{


    public function actionGetFullDataset()
    {

        try {


            $dataset = new DatasetParser($this->user);
            return ["success" => $dataset->init(),
            ];
        } catch (\Exception $exception) {
            return ["error" => $exception->getMessage(),
            ];
        }


    }


    public function actionGetTestingSet()
    {
        try {
            $dataset = new TestingSetParser($this->user);
            return ["success" => $dataset->init()];
        } catch (\Exception $e) {
            return ["error" => $e->getMessage(),
            ];
        }


    }

    public function actionUploadMasks()
    {

        $total_result = [];
        $request = Yii::$app->getRequest()->getRawBody();


        $request = Json::decode($request);
        $testing_id = isset($request["testing_id"]) && $request["testing_id"] ? $request["testing_id"] : null;


        $complete_id = AIStatus::findOne(["name" => "completed"])->id;
        foreach ($request as $id => $single_image) {


            $image_json = $single_image["image"];
            $shapes = $single_image["shapes"];

            $scores = $single_image["scores"];

            $image = Image::findOne($image_json["id"]);


            if ($image) {

                if ($testing_id)
                    Yii::$app->db->createCommand("
                 delete shape.* from shape
                inner join image_shape on image_shape.shape_id=shape.id and image_shape.image_id=$image->id and testing_id='$testing_id'")->execute();

                try {
                    $attributeSaver = new AttributeSaver($this->user, $image, $single_image);
                    if ($testing_id) $attributeSaver->testing_id = $testing_id;

                    $total_result[$image->id] = $attributeSaver->init();

                    if ($testingImage = TestingImages::findBySql("select * from testing_images where testing_id=$testing_id and image_id=$image->id")->one()) {
                        $testingImage->status_id = $complete_id;


                        if ($testingImage->conclusion_id)
                            $conclusion = Conclusion::findOne(["id" => $testingImage->conclusion_id]);
                        else
                            $conclusion = new Conclusion();
                        $conclusion->shapes = count($shapes);
                        $conclusion->success_json = json_encode($scores);
                        if ($conclusion->save() && !$testingImage->conclusion_id) {
                            $testingImage->conclusion_id = $conclusion->id;
                        }

                        $testingImage->save();


                    }


                } catch (\Exception $e) {
                    return ["error" => $e->getMessage(),
                    ];
                }
            }
        }

        return ["success" => $total_result,
        ];
    }


    public function actionBeginTesting($testing_id)
    {
        $running_id = AIStatus::findOne(["name" => "running"])->id;

        $testingModel = Testing::findOne(["id" => $testing_id]);
        if ($testingModel) {
            $testingModel->status_id = $running_id;
            $testingModel->save();
        }


        return ["success" => $testingModel];
    }

    public function actionCompleteTesting($testing_id)
    {
        $completed_id = AIStatus::findOne(["name" => "completed"])->id;

        $testingModel = Testing::findOne(["id" => $testing_id]);
        if ($testingModel) {
            $testingModel->status_id = $completed_id;
            $testingModel->save();
        }


        return ["success" => $testingModel];
    }

    public function actionUploadTrainingWeights()
    {
        $request = Yii::$app->getRequest()->getRawBody();


        $request = Json::decode($request);

        if (isset($request["weight"]) && $request["weight"]
            && isset($request["training_id"]) && $request["training_id"] && $trainingWeight = TrainingWeights::findBySql("select * from training_weights where training_id={$request["training_id"]}")->one()) {

            $weightJSON = $request["weight"];
            if (isset($weightJSON["id"]))
                $weightFile = WeightFile::findOne(["id" => $weightJSON["id"]]);
            else
                $weightFile = new WeightFile();
            $weightFile->setAttributes($weightJSON);

            if ($weightFile->save()) {
                return ["success" => $weightFile];
            } else
                return ["error" => $weightFile->getFirstErrors(),
                ];

        }
        return ["error" => "wrong params need weight and training_id"];
    }

    public function actionGetEssentials()
    {
        $result = [];
        $result["classifications"] = Classification::find()->all();
        $result["shape_types"] = ShapeType::find()->all();


        return ["success" => $result];
    }


}
