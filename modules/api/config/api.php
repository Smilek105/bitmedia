<?php

$db = require(__DIR__ . '/../../../config/db.php');
$params = require(__DIR__ . '/../../../config/params.php');

$config = [
    'id' => 'basic',
    'name' => 'TimeTracker',
    // Need to get one level up:
    'basePath' => dirname(__DIR__) . '/api',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // Enable JSON Input:
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    // Create API log in the standard log dir
                    // But in file 'api.log':
                    'logFile' => '@app/runtime/logs/api.log',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' =>  \app\modules\api\controllers\CategoryController::class,
                    'pluralize' => true,
                ],
            ],
        ],
        'db' => $db,
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],
    ],
    'modules' => [

    ],
    'params' => $params,
];

return $config;