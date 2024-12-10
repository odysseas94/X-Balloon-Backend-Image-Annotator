<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$name = "x-balloon";

$config = [
    'id' => $name,
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],

    "language" => "en",
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => md5($name),
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],


        'user' => [
            'identityClass' => 'app\models\pure\User',
            'enableAutoLogin' => true,
            'authTimeout' => 24 * 60 * 3600, // auth expire
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        "session" => [
            "name" => $name
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'forceTranslation' => true,
                    'basePath' => '@app/messages'
                ],

            ],
        ],

//        'urlManager' => [
//            'enablePrettyUrl' => true,
//            'enableStrictParsing' => true,
//            'showScriptName' => true,
//            'rules' => [
//                '<controller:\w+>/<id:\d+>' => '<controller>/view',
//                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
//                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
//                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/rest/user'],
//            ],
//        ],
    ],


    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ]
    ],

    'params' => $params,
    'homeUrl' => ['dashboard/index'],
    'defaultRoute' => 'dashboard/index',
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ["*", '127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ["*", '127.0.0.1', '::1'],
    ];
}

return $config;
