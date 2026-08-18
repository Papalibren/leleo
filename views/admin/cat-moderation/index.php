<?php
// views/admin/cat-moderation/index.php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\CatModeration;

$this->title = 'Модерация изменений кошек';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-moderation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'cat_id',
                'value' => function ($model) {
                    return $model->cat ? Html::a($model->cat->name, ['/admin/cat/view', 'id' => $model->cat_id]) : $model->cat_id;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    return $model->user ? $model->user->gfn() : $model->user_id;
                },
            ],
            [
                'attribute' => 'changes_summary',
                'value' => function ($model) {
                    return \yii\helpers\StringHelper::truncate($model->changes_summary, 100);
                },
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->getStatusLabel();
                },
                'filter' => CatModeration::getStatusesArray(),
            ],
            'created_at:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {approve} {reject}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('Просмотр', $url, ['class' => 'btn btn-sm btn-primary']);
                    },
                    'approve' => function ($url, $model, $key) {
                        if ($model->status === CatModeration::STATUS_PENDING) {
                            return Html::a('Принять', ['approve', 'id' => $model->id], [
                                'class' => 'btn btn-sm btn-success',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите принять эти изменения?',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                        return '';
                    },
                    'reject' => function ($url, $model, $key) {
                        if ($model->status === CatModeration::STATUS_PENDING) {
                            return Html::a('Отклонить', ['reject', 'id' => $model->id], [
                                'class' => 'btn btn-sm btn-danger',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите отклонить эти изменения?',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                        return '';
                    },
                ],
            ],
        ],
    ]); ?>
</div>