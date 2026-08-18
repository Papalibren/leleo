<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "cat_documents".
 *
 * @property int $id
 * @property int $cat_id
 * @property string $document_path
 * @property string|null $status
 * @property string|null $uploaded_at
 *
 * @property Cat $cat
 */
class CatDocuments extends \yii\db\ActiveRecord
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
        return 'cat_documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_id', 'document_path'], 'required'],
            [['cat_id'], 'integer'],
            [['status'], 'string'],
            [['uploaded_at'], 'safe'],
            [['documentFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, webp', 'maxFiles' => 3],
            [['document_path'], 'string', 'max' => 255],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cat::class, 'targetAttribute' => ['cat_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'document_path' => 'Document Path',
            'status' => 'Status',
            'uploaded_at' => 'Uploaded At',
            'documentFiles' => 'Фото документов'
        ];
    }

    /**
     * Gets query for [[Cat]].
     *
     * @return \yii\db\ActiveQuery
     */
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
        if ($this->validate(['documentFiles'])) {
            $path = 'uploads/cat_documents/';
            $success = true;

            foreach ($this->documentFiles as $index => $file) {
                $filename = uniqid() . '.' . $file->extension;
                $fullPath = Yii::getAlias('@webroot') . '/' . $path . $filename;

                if (!is_dir(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0775, true);
                }

                if ($file->saveAs($fullPath)) {
                    $document = new CatDocuments();
                    $document->cat_id = $this->cat_id;
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
