<?php
// views/admin/ads/view-cat.php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Cat $model */

$this->title = 'Объявление: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ads-view">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('Редактировать', ['update', 'type' => 'cat', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Назад', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'breed',
            [
                'attribute' => 'is_for_sale',
                'value' => $model->is_for_sale ? 'Да' : 'Нет',
            ],
            [
                'attribute' => 'is_for_mating',
                'value' => $model->is_for_mating ? 'Да' : 'Нет',
            ],
            'price:currency',
            [
                'attribute' => 'is_ad_active',
                'value' => $model->is_ad_active ? 'Активно' : 'Неактивно',
            ],
            'sale_contacts:ntext',
            'mating_contacts:ntext',
            'additional_info:ntext',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
</div>