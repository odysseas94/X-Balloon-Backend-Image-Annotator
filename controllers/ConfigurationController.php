<?php

namespace app\controllers;

use app\models\pure\DatasetConfiguration;
use app\models\pure\TestingConfiguration;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class ConfigurationController extends AuthedController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
            ],
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ]
        ];


    }

    public function actionAjaxDatasetConfiguration($dataset_id, $configuration_id): array
    {
        $model = DatasetConfiguration::findOne(["dataset_id" => $dataset_id, 'configuration_id' => $configuration_id]);
        if (!$model) {
            $model = new DatasetConfiguration();
            $model->configuration_id = $configuration_id;
            $model->dataset_id = $dataset_id;
        }
        $post = \Yii::$app->request->post();
        if (isset($post["editableIndex"]) && isset($post["DatasetConfigurationSearch"])) {
            $editableIndex = $post['editableIndex'];
            if (isset($post["DatasetConfigurationSearch"][$editableIndex]) && isset($post["DatasetConfigurationSearch"][$editableIndex]["value"])) {
                $value = $post["DatasetConfigurationSearch"][$editableIndex]["value"];
                $model->value = $value;
                if ($model->save()) {
                    return ['success'];
                }
            }
        }
        throw new HttpException(400, "error");
    }


    public function actionAjaxTestingConfiguration($testing_id, $configuration_id)
    {
        $model = TestingConfiguration::findOne(["testing_id" => $testing_id, 'configuration_id' => $configuration_id]);
        if (!$model) {
            $model = new TestingConfiguration();
            $model->configuration_id = $configuration_id;
            $model->testing_id = $testing_id;
        }
        $post = \Yii::$app->request->post();
        if (isset($post["editableIndex"]) && isset($post["TestingConfigurationSearch"])) {
            $editableIndex = $post['editableIndex'];
            if (isset($post["TestingConfigurationSearch"][$editableIndex]) && isset($post["TestingConfigurationSearch"][$editableIndex]["value"])) {
                $value = $post["TestingConfigurationSearch"][$editableIndex]["value"];
                $model->value = $value;
                if ($model->save()) {
                    return ['success'];
                }
            }
        }
        throw new HttpException(400, "error");
    }
}