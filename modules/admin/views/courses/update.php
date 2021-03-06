<?php

use app\modules\admin\controllers\CoursesController;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Courses */
/* @var $fullNames CoursesController */

$this->title = 'Update Courses: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="courses-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'fullNames' => $fullNames,
    ]) ?>

</div>
