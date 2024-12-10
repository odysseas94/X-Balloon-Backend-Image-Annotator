<?php

namespace app\controllers\api\v1;

use app\models\LoginForm;
use Yii;

abstract class BasicController extends \yii\web\Controller
{

    public $enableCsrfValidation = false;
    public $user = null;


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
            ],
            'basicAuth' => [
                'class' => \yii\filters\auth\HttpBasicAuth::className(),
                'auth' => function ($username, $password) {
                    $login_form = new  LoginForm();
                    $login_form->username = $username;
                    $login_form->password = $password;


                    if (($user = $login_form->getUser()) && $user->validatePassword($password)) {

                        $this->user = $user;
                        return $user;
                    }
                    return null;
                },
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

    public function beforeAction($action)
    {


        if (!$this->user)
            $this->user = Yii::$app->user->identity;
        return parent::beforeAction($action);
    }


}
