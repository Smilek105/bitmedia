<?php

namespace app\models;

use phpDocumentor\Reflection\Types\This;
use Yii;
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
    public function getCoursesCategories(): \yii\db\ActiveQuery
    {
        return $this->hasMany(CoursesCategories::className(), ['course_id' => 'id']);
    }


    public function getCategories(): \yii\db\ActiveQuery
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

    public function getTeacherFullName(): string
    {
        $teacherFullName = $this->teacher0->surname . ' ' . mb_substr($this->teacher0->name, 0, 1) . '.';
        if (!($this->teacher0->patronymic == '')) {
            $teacherFullName .= ' ' . mb_substr($this->teacher0->patronymic, 0, 1) . '.';
        }
        return $teacherFullName;
    }

    public function getNamesSelectedCategories(): string
    {
        $selectedCategories = ArrayHelper::getColumn($this->getCategories()->select('name')->asArray()->all(), 'name');
        $res = '';
        for ($i=0; $i<count($selectedCategories); $i++) {
            if($i != 0){
                $res.= ' <br> ';
            }
            $res.=$selectedCategories[$i];
        }

        return $res;
    }

}
