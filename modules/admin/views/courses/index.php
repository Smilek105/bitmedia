<?php

use app\modules\admin\controllers\CoursesController;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CoursessSeach */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $teacherFullNames app\modules\admin\controllers\CoursesController*/

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courses-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Courses', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id',
                'headerOptions' => ['style' => 'width:6%'],
            ],
            'name',
            ['attribute' => 'hour',
                'headerOptions' => ['style' => 'width:6%'],
            ],
            'description:ntext',
            ['attribute' => 'teacher',
                'label' => 'Teacher_id',
                'value' => 'teacher',
                'headerOptions' => ['style' => 'width:5%'],

            ],
            [   'label' => 'Teacher',
                'value' => 'teacherFullName',
                'headerOptions' => ['style' => 'width:10%'],
                'filter' => CoursesController::getTeacherFullNames(),
                'filterInputOptions' => ['class' => 'form-control form-control-sm'],
            ],

            ['attribute' => 'Categories',
                'format' => 'raw',
                'value' => 'namesSelectedCategories',
            ],

            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
            ],
        ],
    ]); ?>


</div>
