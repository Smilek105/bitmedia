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
            [['image'], 'file', 'extensions' => 'jpeg,png,jpg'],
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

    public function beforeSave($insert) : bool
    {
        $this->deleteImage($this->oldAttributes);
        return parent::beforeSave($insert);
    }

    public function saveImage()
    {
        $file = UploadedFile::getInstance($this, 'image');
        if ($file != null) {
            $file_name = strtolower(md5(uniqid($file->baseName)) . '.' . $file->extension);
            $file->saveAs(Yii::getAlias('..\web\uploads\\' . $file_name));
            $this->image = $file_name;
        }
    }

    public function beforeDelete(): bool
    {
        $this->deleteImage($this->attributes);
        return parent::beforeDelete();

    }

    public function deleteImage($image)
    {
        if ($image!= null) {
            if ($image['image'] != null) {
                if (file_exists(Yii::getAlias('..\web\uploads\\' . $image['image']))) {
                    unlink('..\web\uploads\\' . $image['image']);
                }
            }
        }
    }

    public function getImage(){
        if($this->image){
            return '/uploads/'. $this->image;
        }
        return '/no-image.png';
    }

}
