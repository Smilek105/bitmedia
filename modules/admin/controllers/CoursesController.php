<?php

namespace app\modules\admin\controllers;

use app\models\Categories;
use Yii;
use app\models\Courses;
use app\models\CoursessSeach;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CoursesController implements the CRUD actions for Courses model.
 */
class CoursesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Courses models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CoursessSeach();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Courses model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'fullNames' => $this->getTeachersFullName(),
        ]);
    }

    /**
     * Creates a new Courses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Courses();
        $fullNames = $this->getTeachersFullName();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'fullNames' => $fullNames,
        ]);
    }

    /**
     * Updates an existing Courses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $fullNames = $this->getTeachersFullName();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'fullNames' => $fullNames,
        ]);
    }

    /**
     * Deletes an existing Courses model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Courses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Courses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Courses::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSetCategories($id)
    {
        $course = $this->findModel($id);
        $selectedCategories = $course->getSelectedCategories();
        $categories = $this->getAllCategories();

        if (Yii::$app->request->isPost) {
            $categories = Yii::$app->request->post('categories');
            $course->saveCategories($categories);
            return $this->redirect(['view', 'id'=>$course->id]);
        }

        return $this->render('categories', [
            'model' => $course,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories,
        ]);
    }

    public function getTeachersFullName(): array
    {
        $sql = "SELECT id, CONCAT(surname, ' ',LEFT(name, 1), '. ', CASE WHEN (LEFT(patronymic,1)<> '') THEN CONCAT(LEFT(patronymic,1),'.') ELSE '' END) AS name FROM teachers";
        return ArrayHelper::map(\app\models\Teachers::findBySql($sql)->all(), 'id', 'name');
    }

    public function getAllCategories(): array
    {
        $sql = "SELECT id, name FROM categories";
        return ArrayHelper::map(\app\models\Teachers::findBySql($sql)->all(), 'id', 'name');
    }



}
