<?php
// models/CatHistory.php

namespace app\models;

use Yii;

class CatHistory extends \yii\db\ActiveRecord
{
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_STATUS_CHANGE = 'status_change';
    const ACTION_PHOTO_ADD = 'photo_add';
    const ACTION_PHOTO_REMOVE = 'photo_remove';

    const STATUS_NOT_MODERATED = 0;
    const STATUS_PENDING = 1;
    const STATUS_REJECTED = 2;
    const STATUS_APPROVED = 3;

    public static function tableName()
    {
        return 'cat_history';
    }

    public function rules()
    {
        return [
            [['cat_id', 'user_id', 'action'], 'required'],
            [['cat_id', 'user_id', 'status', 'moderated_by'], 'integer'],
            [['old_value', 'new_value'], 'string'],
            [['created_at', 'updated_at', 'moderated_at'], 'safe'],
            [['action', 'field_name', 'change_type'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Кошка',
            'user_id' => 'Пользователь',
            'action' => 'Действие',
            'field_name' => 'Поле',
            'old_value' => 'Было',
            'new_value' => 'Стало',
            'change_type' => 'Тип изменения',
            'status' => 'Статус',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'moderated_by' => 'Модератор',
            'moderated_at' => 'Время модерации',
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

    public function getModeratedBy()
    {
        return $this->hasOne(User::class, ['id' => 'moderated_by']);
    }

    public function getFieldLabel()
    {
        $model = new Cat();
        return $model->getAttributeLabel($this->field_name) ?? $this->field_name;
    }
}