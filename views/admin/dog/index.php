<?php

use app\models\Dog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Собаки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dog-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'contentOptions' => ['style' => 'width: 60px; text-align: center;'],
            ],
            'name',
            //'translit',
            //'breed',
            'birth_date',
            //'gender',
            //'color_id',
            //'pedigree_number',
            //'chip',
            //'is_for_mating',
            //'mating_contacts:ntext',
            //'is_for_sale',
            //'sale_contacts:ntext',
            //'price',
            //'owner_id',
            //'breeder_id',
            //'father_id',
            //'mother_id',
            //'titles:ntext',
            //'additional_info:ntext',

            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y H:i']
            ],
            //'updated_at',
            [
                'attribute' => 'is_active',
                'format' => 'raw',
                'label' => 'Статус',
                'value' => function ($model) {
                    if ($model->is_active == 1) {
                        return '<span class="badge bg-success">на сайте</span>';
                    } else {
                        return '<span class="badge bg-info">на модерации</span>';
                    }
                },
            ],

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, dog $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'contentOptions' => ['style' => 'width: 90px; text-align: center;'],

            ],
        ],
    ]); ?>


</div>