<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'Admin(Vizit-M)',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'debug'],
    'defaultRoute' => 'request/new',
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['*']
        ],
        'gii'	=> [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*'],
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'vizitm\entities\Users',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => ['auth/login'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => '', //site/index
                '<_a:login|logout>' => 'auth/<_a>',
            ],
        ],
    ],
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'except' => ['auth/login', 'site/error'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    'params' => $params,
];
