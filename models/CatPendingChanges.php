<?php
// models/CatPendingChanges.php

namespace app\models;

use Yii;

class CatPendingChanges extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    public static function tableName()
    {
        return 'cat_pending_changes';
    }

    public function rules()
    {
        return [
            [['cat_id', 'user_id', 'field_name'], 'required'],
            [['cat_id', 'user_id', 'status'], 'integer'],
            [['old_value', 'new_value'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['field_name'], 'string', 'max' => 100],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cat::class, 'targetAttribute' => ['cat_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'user_id' => 'User ID',
            'field_name' => 'Field Name',
            'old_value' => 'Old Value',
            'new_value' => 'New Value',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getCat()
    {
        return $this->hasOne(Cat::class, ['id' => 'cat_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = date('Y-m-d H:i:s');
        }
        $this->updated_at = date('Y-m-d H:i:s');
        return parent::beforeSave($insert);
    }
}