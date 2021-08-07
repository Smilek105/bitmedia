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
            [['name', 'image'], 'required'],
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

    public function beforeSave($insert)
    {
        if ($this->oldAttributes != null) {
            if ($this->oldAttributes['image'] != null) {
                if (file_exists(Yii::getAlias('..\web\uploads\\' . $this->oldAttributes['image']))) {
                    unlink('..\web\uploads\\' . $this->oldAttributes['image']);
                }
            }
        }
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
        if ($this->attributes!= null) {
            if ($this->attributes['image'] != null) {
                if (file_exists(Yii::getAlias('..\web\uploads\\' . $this->attributes['image']))) {
                    unlink('..\web\uploads\\' . $this->attributes['image']);
                }
            }
        }
        return parent::beforeDelete();

    }


}
