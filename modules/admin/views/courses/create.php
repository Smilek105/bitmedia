<?php

use app\modules\admin\controllers\CoursesController;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Courses */
/* @var $fullNames CoursesController */

$this->title = 'Create Courses';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'fullNames' => $fullNames,
    ]) ?>

</div>
