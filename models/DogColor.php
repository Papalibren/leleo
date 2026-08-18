<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dog_color".
 *
 * @property int $id
 * @property string $name
 * @property string|null $image_path
 * @property string $breed
 *
 * @property Dog[] $dogs
 */
class DogColor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dog_color';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'breed'], 'required'],
            [['breed'], 'string'],
            [['name'], 'string', 'max' => 150],
            [['image_path'], 'string', 'max' => 255],
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
            'image_path' => 'Image Path',
            'breed' => 'Breed',
        ];
    }

    /**
     * Gets query for [[Dogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDogs()
    {
        return $this->hasMany(Dog::class, ['color_id' => 'id']);
    }

    // models/DogColor.php
    public static function getColorsByBreed($breed)
    {
        return self::find()
            ->select(['name', 'id'])
            ->where(['breed' => $breed])
            ->orderBy('name ASC')
            ->indexBy('id')
            ->column();
    }
}
