<?php
// views/user/nursery/index.php

use app\models\Nursery;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Питомники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nursery-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="bi bi-plus-circle"></i> Добавить питомник', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // Фото питомника
            [
                'attribute' => 'photo',
                'format' => 'html',
                'label' => 'Логотип',
                'value' => function($model) {
                    if ($model->photo) {
                        return Html::img('/' . $model->photo, [
                            'style' => 'width: 50px; height: 50px; object-fit: cover;',
                            'class' => 'img-thumbnail'
                        ]);
                    }
                    return Html::tag('span', 'Нет фото', ['class' => 'text-muted']);
                },
                'contentOptions' => ['style' => 'width: 70px;']
            ],

            // Название питомника
            [
                'attribute' => 'title',
                'label' => 'Название',
                'format' => 'html',
                'value' => function($model) {
                    return Html::a(Html::encode($model->title), ['view', 'id' => $model->id], [
                        'title' => 'Просмотреть питомник'
                    ]);
                }
            ],

            // Заводчик
            [
                'attribute' => 'breeder_id',
                'label' => 'Заводчик',
                'value' => function($model) {
                    return $model->breeder ? $model->breeder->gfn() : 'не указан';
                }
            ],


            // Телефон
            [
                'attribute' => 'phone',
                'label' => 'Телефон',
                'value' => function($model) {
                    return $model->phone ?: 'не указан';
                }
            ],

            // Сайт
            [
                'attribute' => 'url',
                'label' => 'Сайт',
                'format' => 'html',
                'value' => function($model) {
                    return $model->url ? Html::a($model->url, $model->url, [
                        'target' => '_blank',
                        'title' => 'Перейти на сайт'
                    ]) : 'не указан';
                }
            ],

            // Действия
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="bi bi-eye"></i>', $url, [
                            'class' => 'btn btn-sm btn-primary',
                            'title' => 'Просмотреть'
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="bi bi-pencil"></i>', $url, [
                            'class' => 'btn btn-sm btn-secondary',
                            'title' => 'Редактировать'
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="bi bi-trash"></i>', $url, [
                            'class' => 'btn btn-sm btn-danger',
                            'title' => 'Удалить',
                            'data' => [
                                'confirm' => 'Вы уверены, что хотите удалить этот питомник?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
                'contentOptions' => ['style' => 'width: 130px;', 'class' => 'text-center'],
            ],
        ],
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
    ]); ?>
</div>