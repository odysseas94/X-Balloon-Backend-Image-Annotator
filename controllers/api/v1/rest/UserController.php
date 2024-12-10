<?php

namespace app\controllers\api\v1\rest;

use yii\rest\ActiveController;

class UserController extends ActiveController {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
            ],
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to domains:
                    'Origin' => ["*"],
                    'Access-Control-Request-Method' => ['*'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600, // Cache (seconds)
                ],
            ],
        ];
    }

    public $modelClass = 'app\models\pure\User';

}
