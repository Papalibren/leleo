<?php
// models/CatModeration.php

namespace app\models;

use Yii;

class CatModeration extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    public static function tableName()
    {
        return 'cat_moderation';
    }

    public function rules()
    {
        return [
            [['cat_id', 'user_id'], 'required'],
            [['cat_id', 'user_id', 'status', 'moderated_by'], 'integer'],
            [['data_before', 'data_after', 'changes_summary'], 'string'],
            [['created_at', 'updated_at', 'moderated_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Кошка',
            'user_id' => 'Пользователь',
            'data_before' => 'Данные до',
            'data_after' => 'Данные после',
            'changes_summary' => 'Описание изменений',
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

    public function getChangesArray()
    {
        $before = json_decode($this->data_before, true) ?? [];
        $after = json_decode($this->data_after, true) ?? [];
        $changes = [];

        foreach ($after as $field => $newValue) {
            $oldValue = $before[$field] ?? null;
            if ($oldValue != $newValue) {
                $changes[$field] = [
                    'old' => $oldValue,
                    'new' => $newValue,
                ];
            }
        }

        return $changes;
    }

    public function getStatusLabel()
    {
        $statuses = [
            self::STATUS_PENDING => 'На модерации',
            self::STATUS_APPROVED => 'Принято',
            self::STATUS_REJECTED => 'Отклонено',
        ];
        return $statuses[$this->status] ?? 'Неизвестно';
    }
    public static function getStatusesArray()
    {
        return [
            self::STATUS_PENDING => 'На модерации',
            self::STATUS_APPROVED => 'Принято',
            self::STATUS_REJECTED => 'Отклонено',
        ];
    }
}
