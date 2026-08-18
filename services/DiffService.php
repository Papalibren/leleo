<?php
// services/DiffService.php

namespace app\services;

use yii\helpers\Html;

class DiffService
{
    public static function compareValues($oldValue, $newValue, $fieldName = '')
    {
        if ($oldValue === $newValue) {
            return $newValue;
        }

        $old = is_null($oldValue) ? '<em>пусто</em>' : Html::encode($oldValue);
        $new = is_null($newValue) ? '<em>пусто</em>' : Html::encode($newValue);

        return sprintf(
            '<div class="diff-change"><span class="diff-old">%s</span> → <span class="diff-new">%s</span></div>',
            $old,
            $new
        );
    }

    public static function generateDiffTable($oldData, $newData, $fieldLabels = [])
    {
        $html = '<table class="table table-bordered diff-table">';
        $html .= '<thead><tr><th>Поле</th><th>Было</th><th>Стало</th></tr></thead><tbody>';

        foreach ($newData as $field => $newValue) {
            $oldValue = $oldData[$field] ?? null;

            if ($oldValue != $newValue) {
                $fieldLabel = $fieldLabels[$field] ?? $field;
                $html .= sprintf(
                    '<tr class="diff-row"><td>%s</td><td>%s</td><td>%s</td></tr>',
                    Html::encode($fieldLabel),
                    is_null($oldValue) ? '<em>пусто</em>' : Html::encode($oldValue),
                    is_null($newValue) ? '<em>пусто</em>' : Html::encode($newValue)
                );
            }
        }

        $html .= '</tbody></table>';
        return $html;
    }
}