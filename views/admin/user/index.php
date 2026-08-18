<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи сайта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_search', ['model' => $searchModel]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table'],
        'rowOptions' => function ($model) {
            return $model->is_active == 0 ? ['class' => 'table-danger'] : [];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'email:email',
            'first_name',
            'last_name',
            //'middle_name',
            'country',
            'city',
            //'is_admin',
            //'is_active',
            //'is_advanced',
            //'advanced_until',
            //'cookie_token',
            //'password_reset_token',
            //'password_reset_expires_at',
            //'accept_privacy_policy',
            //'created_at',
            //'updated_at',
            [
                'attribute' => 'is_active',
                'label' => 'Статус',
                'value' => function ($model) {
                    return $model->is_active ? 'Активен' : 'Заблокирован';
                },
                'contentOptions' => ['style' => 'width: 120px;'],
            ],
            [
                'attribute' => 'is_advanced',
                'label' => 'Тип',
                'value' => function ($model) {
                    return $model->is_advanced ? 'Продвинутый' : 'Обычный';
                },
                'contentOptions' => ['style' => 'width: 130px;'],
            ],

            [
                'class' => ActionColumn::class,
                'template' => '{view} {delete}',
                'contentOptions' => ['style' => 'white-space: nowrap'],
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<i class="bi bi-eye"></i>',
                            $url,
                            ['class' => 'btn btn-primary btn-sm', 'title' => 'Просмотр']
                        );
                    },
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<i class="bi bi-pencil"></i>',
                            $url,
                            ['class' => 'btn btn-warning btn-sm', 'title' => 'Редактировать']
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<i class="bi bi-trash"></i>',
                            $url,
                            [
                                'class' => 'btn btn-danger btn-sm',
                                'title' => 'Удалить',
                                'data-confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
                                'data-method' => 'post',
                            ]
                        );
                    },
                ],
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
            ],
        ],
    ]); ?>


</div>