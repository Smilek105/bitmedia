<?php

use app\models\Courses;
use app\modules\admin\controllers\CoursesController;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CoursesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $fullNames CoursesController */
/* @var $model Courses */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courses-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Courses', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['style' => 'width:3%'],],
            ['attribute' => 'id',
                'headerOptions' => ['style' => 'width:6%'],
            ],

            ['attribute' => 'name',
                'headerOptions' => ['style' => 'width:12%'],
            ],
            ['attribute' => 'hour',
                'headerOptions' => ['style' => 'width:6%'],
            ],
            ['attribute' => 'description',
                'format' => 'ntext',
                'headerOptions' => ['style' => 'width:50%'],
            ],
            ['attribute' => 'teacher',
                'label' => 'Teacher',
                'value' => function ($model) {
                    return $model->teacher0->getFullName();
                }
                ,
                'filter' => $fullNames,
                'headerOptions' => ['style' => 'width:13%'],

            ],

            ['attribute' => 'Categories',
                'format' => 'raw',
                'value' => 'namesSelectedCategories',
                'headerOptions' => ['style' => 'width:10%'],
            ],

            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
            ],
        ],
    ]); ?>


</div>
