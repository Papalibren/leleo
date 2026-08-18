<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "cat_photos".
 *
 * @property int $id
 * @property int $cat_id
 * @property string $image_path
 * @property int|null $sort_order
 *
 * @property Cat $cat
 */
class CatPhotos extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public static function tableName()
    {
        return 'cat_photos';
    }

    public function rules()
    {
        return [
            [['cat_id'], 'required'],
            [['cat_id', 'sort_order'], 'integer'],
            [['image_path'], 'string', 'max' => 255],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp', 'maxFiles' => 3],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cat::class, 'targetAttribute' => ['cat_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Кошка',
            'image_path' => 'Путь к изображению',
            'imageFiles' => 'Фотографии (до 3-х)',
            'sort_order' => 'Порядок',
        ];
    }

    public function getCat()
    {
        return $this->hasOne(Cat::class, ['id' => 'cat_id']);
    }

    /**
     * Загружает несколько фото и создаёт записи в БД
     * @return bool
     */
    public function uploadMultiple()
    {
        if ($this->validate(['imageFiles'])) {
            $path = 'uploads/cat_photos/';
            $success = true;

            foreach ($this->imageFiles as $index => $file) {
                $filename = uniqid() . '.' . $file->extension;
                $fullPath = Yii::getAlias('@webroot') . '/' . $path . $filename;

                if (!is_dir(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0775, true);
                }

                if ($file->saveAs($fullPath)) {
                    $photo = new CatPhotos();
                    $photo->cat_id = $this->cat_id;
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
