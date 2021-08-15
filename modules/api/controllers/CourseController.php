<?php

namespace app\modules\api\controllers;

use app\models\Courses;
use yii\rest\ActiveController;

class CourseController extends ActiveController
{
    public $modelClass = Courses::class;

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function checkAccess($action, $model=null, $params=[]) {
        return true;
    }

    /**
     * @return array
     */
    public function behaviors() {
        return [
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::class,
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                    'application/xml' => \yii\web\Response::FORMAT_XML
                ],
            ],
        ];
    }


}