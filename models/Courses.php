<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "courses".
 *
 * @property int $id
 * @property string $name
 * @property int $hour
 * @property string $description
 * @property int $teacher
 *
 * @property Teachers $teacher0
 * @property CoursesCategories[] $coursesCategories
 * @property Categories[] $categories
 */
class Courses extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'courses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'hour', 'description', 'teacher'], 'required'],
            [['hour', 'teacher'], 'default', 'value' => null],
            [['hour', 'teacher'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 32],
            [['teacher'], 'exist', 'skipOnError' => true, 'targetClass' => Teachers::className(), 'targetAttribute' => ['teacher' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'hour' => 'Hour',
            'description' => 'Description',
            'teacher' => 'Teacher',
        ];
    }

    /**
     * Gets query for [[Teacher0]].
     *
     * @return ActiveQuery
     */
    public function getTeacher0()
    {
        return $this->hasOne(Teachers::className(), ['id' => 'teacher']);
    }

    /**
     * Gets query for [[CoursesCategories]].
     *
     * @return ActiveQuery
     */
    public function getCoursesCategories(): ActiveQuery
    {
        return $this->hasMany(CoursesCategories::className(), ['course_id' => 'id']);
    }


    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id'])
            ->viaTable('courses_categories', ['course_id' => 'id']);
    }

    public function getSelectedCategories(): array
    {
        $selectedCategories = $this->getCategories()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedCategories, 'id');
    }

    public function saveCategories($categories)
    {
        if (is_array($categories)) {
            $this->clearCurrentCategories();

            foreach ($categories as $category_id) {
                $category = Categories::findOne($category_id);
                $this->link('categories', $category);
            }
        }
    }

    public function clearCurrentCategories()
    {
        CoursesCategories::deleteAll(['course_id' => $this->id]);
    }


    public function getNamesSelectedCategories(): string
    {
        $selectedCategories = ArrayHelper::getColumn($this->getCategories()->select('name')->asArray()->all(), 'name');
        $res = '';
        for ($i = 0; $i < count($selectedCategories); $i++) {
            if ($i != 0) {
                $res .= ' <br> ';
            }
            $res .= $selectedCategories[$i];
        }

        return $res;
    }

}
