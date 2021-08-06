<?php

namespace app\models;

use Yii;

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
class Courses extends \yii\db\ActiveRecord
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
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher0()
    {
        return $this->hasOne(Teachers::className(), ['id' => 'teacher']);
    }

    /**
     * Gets query for [[CoursesCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoursesCategories()
    {
        return $this->hasMany(CoursesCategories::className(), ['course_id' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id'])->viaTable('courses_categories', ['course_id' => 'id']);
    }
}