<?php
// views/admin/cat/history.php

use yii\helpers\Html;
use app\models\CatHistory;

$this->title = 'История изменений кошки: ' . $cat->name;
$this->params['breadcrumbs'][] = ['label' => 'Кошки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $cat->name, 'url' => ['view', 'id' => $cat->id]];
$this->params['breadcrumbs'][] = 'История изменений';
?>
<div class="cat-history">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Пользователь</th>
                    <th>Действие</th>
                    <th>Поле</th>
                    <th>Было</th>
                    <th>Стало</th>
                    <th>Статус</th>
                    <th>Модератор</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $record): ?>
                <tr>
                    <td><?= Yii::$app->formatter->asDatetime($record->created_at) ?></td>
                    <td><?= $record->user ? $record->user->gfn() : $record->user_id ?></td>
                    <td>
                        <?php
                        $actions = [
                            CatHistory::ACTION_CREATE => 'Создание',
                            CatHistory::ACTION_UPDATE => 'Изменение',
                            CatHistory::ACTION_STATUS_CHANGE => 'Смена статуса',
                            CatHistory::ACTION_PHOTO_ADD => 'Добавление фото',
                            CatHistory::ACTION_PHOTO_REMOVE => 'Удаление фото',
                        ];
                        echo $actions[$record->action] ?? $record->action;
                        ?>
                    </td>
                    <td><?= $record->getFieldLabel() ?></td>
                    <td style="max-width: 200px; word-break: break-all;"><?= Html::encode($record->old_value) ?></td>
                    <td style="max-width: 200px; word-break: break-all;"><?= Html::encode($record->new_value) ?></td>
                    <td>
                        <?php
                        $statuses = [
                            CatHistory::STATUS_NOT_MODERATED => '<span class="badge bg-secondary">Не требует</span>',
                            CatHistory::STATUS_PENDING => '<span class="badge bg-warning">На модерации</span>',
                            CatHistory::STATUS_APPROVED => '<span class="badge bg-success">Принято</span>',
                            CatHistory::STATUS_REJECTED => '<span class="badge bg-danger">Отклонено</span>',
                        ];
                        echo $statuses[$record->status] ?? $record->status;
                        ?>
                    </td>
                    <td><?= $record->moderatedBy ? $record->moderatedBy->gfn() : '-' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>