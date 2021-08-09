<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionCourses()
    {
        // название, колличество часов, описание, преподаватель-> , фильтрация по категориям
        // пагинация

        $categories = Yii::$app->db->createCommand('SELECT * FROM categories ORDER BY id')->queryAll();
        $categories_course = Yii::$app->db->createCommand('SELECT * FROM courses_categories')->queryAll();
        $titles = ['#' , 'Название', 'Длительность (часов)', 'Преподаватель'];
        $sql = "SELECT courses.name as course, hour, CONCAT(surname, ' ',LEFT(teachers.name, 1), '. ', CASE WHEN (LEFT(patronymic,1)<> '') THEN CONCAT(LEFT(patronymic,1),'.') ELSE '' END) AS name, courses.id FROM courses INNER JOIN teachers ON courses.teacher = teachers.id";

        $fields = Yii::$app->db->createCommand($sql)->queryAll();


        return $this->render('courses', compact('fields', 'titles', 'categories', 'categories_course'));

    }

}
