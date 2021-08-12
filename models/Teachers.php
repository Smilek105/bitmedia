<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teachers".
 *
 * @property int $id
 * @property string $surname
 * @property string $name
 * @property string|null $patronymic
 * @property string $email
 * @property string $phone
 *
 * @property Courses[] $courses
 */
class Teachers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'teachers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['surname', 'name', 'email', 'phone'], 'required'],
            [['surname', 'name', 'patronymic', 'email'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 24],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'surname' => 'Surname',
            'name' => 'Name',
            'patronymic' => 'Patronymic',
            'email' => 'Email',
            'phone' => 'Phone',
            'fullNames'
        ];
    }

    /**
     * Gets query for [[Courses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Courses::className(), ['teacher' => 'id']);
    }

    public function getFullName(): string
    {
        $fullName = $this->surname . ' ' . mb_substr($this->name, 0, 1) . '.';
        if (!($this->patronymic == '')) {
            $fullName .= ' ' . mb_substr($this->patronymic, 0, 1) . '.';
        }
        return $fullName;
    }
}
