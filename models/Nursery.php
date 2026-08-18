<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nursery".
 *
 * @property int $id
 * @property int $breeder_id
 * @property string $title
 * @property string|null $photo
 * @property string|null $url
 * @property string $country
 * @property string $city
 * @property string $phone
 * @property string|null $info
 *
 * @property User $breeder
 */
class Nursery extends \yii\db\ActiveRecord
{
    public $imageFile;

    public static function tableName()
    {
        return 'nursery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['breeder_id', 'title', 'country', 'city', 'phone'], 'required'],
            [['breeder_id'], 'integer'],
            [['info'], 'string'],
            [['title', 'photo', 'url', 'country', 'city'], 'string', 'max' => 250],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp'],
            [['phone'], 'string', 'max' => 20],
            ['url', 'url'],
            [['breeder_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['breeder_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'breeder_id' => 'Заводчик',
            'title' => 'Название',
            'photo' => 'Фото',
            'url' => 'Url',
            'country' => 'Страна',
            'city' => 'Город',
            'phone' => 'Телефон',
            'info' => 'Информация',
        ];
    }

    /**
     * Gets query for [[Breeder]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBreeder()
    {
        return $this->hasOne(User::class, ['id' => 'breeder_id']);
    }


    public function getPets()
    {
        return $this->hasMany(Cat::class, ['breeder_id' => 'breeder_id']);
    }

    public function getProducers()
    {
        return $this->hasMany(Cat::class, ['owner_id' => 'breeder_id']);
    }



    public function uploadPhoto()
    {
        if ($this->validate(['imageFile'])) {



            $path = 'uploads/nursery/';
            $success = true;
            $file = $this->imageFile;
            $filename = uniqid() . '.' . $file->extension;
            $fullPath = Yii::getAlias('@webroot') . '/' . $path . $filename;

            if (!is_dir(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0775, true);
            }

            if ($file->saveAs($fullPath)) {
                $this->photo = $path . $filename;
                $success = true;
            } else {
                $success = false;
            }
            return $success;
        }

        return false;
    }
}
