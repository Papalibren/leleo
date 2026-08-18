<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "dog_photos".
 *
 * @property int $id
 * @property int $dog_id
 * @property string $image_path
 * @property int|null $sort_order
 *
 * @property Dog $dog
 */
class DogPhotos extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public static function tableName()
    {
        return 'dog_photos';
    }

    public function rules()
    {
        return [
            [['dog_id'], 'required'],
            [['dog_id', 'sort_order'], 'integer'],
            [['image_path'], 'string', 'max' => 255],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp', 'maxFiles' => 3],
            [['dog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dog::class, 'targetAttribute' => ['dog_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dog_id' => 'Собака',
            'image_path' => 'Путь к изображению',
            'imageFiles' => 'Фотографии (до 3-х)',
            'sort_order' => 'Порядок',
        ];
    }

    public function getdog()
    {
        return $this->hasOne(dog::class, ['id' => 'dog_id']);
    }

    /**
     * Загружает несколько фото и создаёт записи в БД
     * @return bool
     */
    public function uploadMultiple()
    {
        if ($this->validate(['imageFiles'])) {
            $path = 'uploads/dog_photos/';
            $success = true;

            foreach ($this->imageFiles as $index => $file) {
                $filename = uniqid() . '.' . $file->extension;
                $fullPath = Yii::getAlias('@webroot') . '/' . $path . $filename;

                if (!is_dir(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0775, true);
                }

                if ($file->saveAs($fullPath)) {
                    $photo = new DogPhotos();
                    $photo->dog_id = $this->dog_id;
                    $photo->image_path = $path . $filename;
                    $photo->sort_order = $index + 1;
                    if (!$photo->save(false)) {
                        $success = false;
                    }
                } else {
                    $success = false;
                }
            }

            return $success;
        }

        return false;
    }
}
