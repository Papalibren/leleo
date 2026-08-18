<?php
// views/admin/cat-moderation/view.php

use yii\helpers\Html;
use app\services\DiffService;
use app\models\CatModeration;

$this->title = 'Модерация изменений кошки: ' . $moderation->cat->name;
$this->params['breadcrumbs'][] = ['label' => 'Модерация изменений кошек', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-moderation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Информация о изменении</h3>
                </div>
                <div class="card-body">
                    <p><strong>Кошка:</strong> <?= Html::a($moderation->cat->name, ['/admin/cat/view', 'id' => $moderation->cat_id]) ?></p>
                    <p><strong>Пользователь:</strong> <?= $moderation->user->gfn() ?></p>
                    <p><strong>Дата изменения:</strong> <?= Yii::$app->formatter->asDatetime($moderation->created_at) ?></p>
                    <p><strong>Статус:</strong> <?= $moderation->getStatusLabel() ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Сравнение изменений</h3>
        </div>
        <div class="card-body">
            <?php
            $oldData = json_decode($moderation->data_before, true) ?? [];
            $newData = json_decode($moderation->data_after, true) ?? [];
            $fieldLabels = (new \app\models\Cat())->attributeLabels();

            echo DiffService::generateDiffTable($oldData, $newData, $fieldLabels);
            ?>
        </div>
    </div>

    <?php if ($moderation->status === CatModeration::STATUS_PENDING): ?>
    <div class="mt-4">
        <?= Html::a('Принять изменения', ['approve', 'id' => $moderation->id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Вы уверены, что хотите принять эти изменения?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Отклонить изменения', ['reject', 'id' => $moderation->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите отклонить эти изменения?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <?php endif; ?>

</div>