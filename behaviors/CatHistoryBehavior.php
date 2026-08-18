<?php
// behaviors/CatHistoryBehavior.php

namespace app\behaviors;

use app\models\CatHistory;
use app\models\CatModeration;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class CatHistoryBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
        ];
    }

    public function afterInsert($event)
    {
        // Логируем создание кошки
        $cat = $this->owner;
        $history = new CatHistory();
        $history->cat_id = $cat->id;
        $history->user_id = Yii::$app->user->id;
        $history->action = CatHistory::ACTION_CREATE;
        $history->change_type = 'create';
        $history->status = CatHistory::STATUS_NOT_MODERATED;
        $history->save();
    }

    public function afterUpdate($event)
    {
        $cat = $this->owner;
        $changedAttributes = $event->changedAttributes;

        // Убираем системные поля
        unset($changedAttributes['updated_at']);

        if (empty($changedAttributes)) {
            return;
        }

        // Логируем каждое измененное поле
        foreach ($changedAttributes as $attr => $oldValue) {
            $newValue = $cat->$attr;

            if ($oldValue == $newValue) {
                continue;
            }

            $history = new CatHistory();
            $history->cat_id = $cat->id;
            $history->user_id = Yii::$app->user->id;
            $history->action = CatHistory::ACTION_UPDATE;
            $history->field_name = $attr;
            $history->old_value = is_array($oldValue) ? json_encode($oldValue) : $oldValue;
            $history->new_value = is_array($newValue) ? json_encode($newValue) : $newValue;
            $history->change_type = 'field_change';
            $history->status = CatHistory::STATUS_PENDING;
            $history->save();
        }

        // Создаем запись для модерации
        $this->createModerationRecord($cat, $changedAttributes);
    }

    private function createModerationRecord($cat, $changedAttributes)
    {
        // Получаем текущие данные
        $currentData = $cat->getAttributes();

        // Формируем данные до изменения
        $oldData = [];
        foreach ($changedAttributes as $attr => $oldValue) {
            $oldData[$attr] = $oldValue;
        }

        // Ищем активную запись модерации
        $moderation = CatModeration::find()
            ->where(['cat_id' => $cat->id, 'status' => CatModeration::STATUS_PENDING])
            ->one();

        if (!$moderation) {
            $moderation = new CatModeration();
            $moderation->cat_id = $cat->id;
            $moderation->user_id = Yii::$app->user->id;
            $moderation->data_before = json_encode($oldData);
        } else {
            // Обновляем существующую запись
            $currentBeforeData = json_decode($moderation->data_before, true) ?? [];
            $oldData = array_merge($currentBeforeData, $oldData);
            $moderation->data_before = json_encode($oldData);
        }

        $moderation->data_after = json_encode($currentData);
        $moderation->changes_summary = $this->generateChangesSummary($oldData, $currentData);
        $moderation->status = CatModeration::STATUS_PENDING;
        $moderation->save();
    }

    private function generateChangesSummary($oldData, $newData)
    {
        $changes = [];
        $model = new \app\models\Cat();

        foreach ($newData as $field => $newValue) {
            $oldValue = $oldData[$field] ?? null;
            if ($oldValue != $newValue) {
                $fieldLabel = $model->getAttributeLabel($field) ?? $field;
                $changes[] = "$fieldLabel: {$oldValue} → {$newValue}";
            }
        }

        return implode("; ", $changes);
    }
}