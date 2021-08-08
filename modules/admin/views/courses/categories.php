<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Courses */
/* @var $form yii\widgets\ActiveForm */
/* @var $categories app\models\Courses */
/* @var $selectedCategories app\models\Courses */
?>

<div class="courses-form">

    <?php $form = ActiveForm::begin(); ?>
    <br>
    <?= Html::dropDownList('categories', $selectedCategories, $categories, ['class'=>'form-control',  'style' => "height: 160px;", 'multiple'=>true]) ?>

    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
