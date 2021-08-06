<?php

namespace app\models;

use Yii;
use yii\db\StaleObjectException;
use yii\web\UploadedFile;


/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 *
 * @property CoursesCategories[] $coursesCategories
 * @property Courses[] $courses
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['image'], 'string'],
            [['name'], 'string', 'max' => 32],
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
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[CoursesCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoursesCategories()
    {
        return $this->hasMany(CoursesCategories::className(), ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Courses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Courses::className(), ['id' => 'course_id'])->viaTable('courses_categories', ['category_id' => 'id']);
    }


    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function save($runValidation = true, $attributeNames = null)
    {
       $this->saveImage();

        if ($this->getIsNewRecord()) {

            return $this->insert($runValidation, $attributeNames);
        }

        return $this->update($runValidation, $attributeNames) !== false;
    }

    public function uploadFile($file)
    {
        $file->saveAs(Yii::getAlias('C:\OpenServer\domains\bitmedia\web\uploads\/'.$file->name));
    }

    public function saveImage(){
        $file = UploadedFile::getInstance($this, 'image');
        $this->uploadFile($file);
        $this->image= $file->name;
    }


}
