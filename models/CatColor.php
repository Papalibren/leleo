<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_color".
 *
 * @property int $id
 * @property string $name
 * @property string|null $image_path
 *
 * @property Cat[] $cats
 */
class CatColor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cat_color';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
        ];
    }

    /**
     * Gets query for [[Cats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCats()
    {
        return $this->hasMany(Cat::class, ['color_id' => 'id']);
    }
}
