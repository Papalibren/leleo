<?php
// views/admin/ads/index.php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\AdsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Управление объявлениями';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ads-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Форма поиска -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Поиск объявлений</h5>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
                'options' => ['class' => 'form-inline'],
            ]); ?>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($searchModel, 'search')->textInput([
                        'placeholder' => 'Поиск по имени, родословной...'
                    ])->label(false) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($searchModel, 'ad_type')->dropDownList([
                        '' => 'Все объявления',
                        'sale' => 'Для продажи',
                        'mating' => 'Для вязки'
                    ])->label(false) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($searchModel, 'status')->dropDownList([
                        '' => 'Все статусы',
                        'active' => 'Активные',
                        'inactive' => 'Неактивные'
                    ])->label(false) ?>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <?= Html::submitButton('<i class="bi bi-search"></i> Поиск', ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="bi bi-arrow-clockwise"></i> Сброс', ['index'], ['class' => 'btn btn-secondary']) ?>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <!-- Таблица объявлений -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'label' => 'Имя',
                'format' => 'html',
                'value' => function($model) {
                    return Html::a(Html::encode($model['name']), ['view', 'type' => $model['type'], 'id' => $model['id']], [
                        'title' => 'Просмотреть объявление'
                    ]);
                }
            ],

            [
                'attribute' => 'animal_type',
                'label' => 'Тип',
            ],

            [
                'attribute' => 'breed',
                'label' => 'Порода',
            ],

            [
                'attribute' => 'is_for_sale',
                'label' => 'Продажа',
                'format' => 'boolean',
            ],

            [
                'attribute' => 'is_for_mating',
                'label' => 'Вязка',
                'format' => 'boolean',
            ],

            [
                'attribute' => 'price',
                'label' => 'Цена',
                'format' => 'currency',
            ],

            [
                'attribute' => 'is_ad_active',
                'label' => 'Активно',
                'format' => 'boolean',
            ],

            [
                'attribute' => 'created_at',
                'label' => 'Создано',
                'format' => 'datetime',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="bi bi-eye"></i>',
                            ['view', 'type' => $model['type'], 'id' => $model['id']],
                            ['class' => 'btn btn-sm btn-primary', 'title' => 'Просмотреть']
                        );
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="bi bi-pencil"></i>',
                            ['update', 'type' => $model['type'], 'id' => $model['id']],
                            ['class' => 'btn btn-sm btn-secondary', 'title' => 'Редактировать']
                        );
                    },
                ],
                'contentOptions' => ['style' => 'width: 100px;', 'class' => 'text-center'],
            ],
        ],
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
    ]); ?>
</div>