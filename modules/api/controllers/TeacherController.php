<?php

namespace app\modules\api\controllers;

use app\models\Teachers;
use yii\rest\ActiveController;

class TeacherController extends ActiveController
{
    public $modelClass = Teachers::class;

}