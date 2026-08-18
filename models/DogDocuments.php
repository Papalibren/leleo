<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "dog_documents".
 *
 * @property int $id
 * @property int $dog_id
 * @property string $document_path
 * @property string|null $status
 * @property string|null $uploaded_at
 *
 * @property dog $dog
 */
class DogDocuments extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile[]
     */
    public $documentFiles;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dog_documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dog_id', 'document_path'], 'required'],
            [['dog_id'], 'integer'],
            [['status'], 'string'],
            [['uploaded_at'], 'safe'],
            [['documentFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, webp', 'maxFiles' => 3],
            [['document_path'], 'string', 'max' => 255],
            [['dog_id'], 'exist', 'skipOnError' => true, 'targetClass' => dog::class, 'targetAttribute' => ['dog_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dog_id' => 'dog ID',
            'document_path' => 'Document Path',
            'status' => 'Status',
            'uploaded_at' => 'Uploaded At',
            'documentFiles' => 'Фото документов'
        ];
    }

    /**
     * Gets query for [[dog]].
     *
     * @return \yii\db\ActiveQuery
     */
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
        if ($this->validate(['documentFiles'])) {
            $path = 'uploads/dog_documents/';
            $success = true;

            foreach ($this->documentFiles as $index => $file) {
                $filename = uniqid() . '.' . $file->extension;
                $fullPath = Yii::getAlias('@webroot') . '/' . $path . $filename;

                if (!is_dir(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0775, true);
                }

                if ($file->saveAs($fullPath)) {
                    $document = new DogDocuments();
                    $document->dog_id = $this->dog_id;
                    $document->document_path = $path . $filename;

                    if (!$document->save(false)) {
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
