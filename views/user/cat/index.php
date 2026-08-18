<?php

use app\models\Cat;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;



$this->title = 'Мои кошки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'translit',
            'breed',
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
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Cat $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                     'template' => '{view} {update}',
    'buttons' => [
        'view' => function ($url, $model, $key) {
            return Html::a('<i class="bi bi-eye"></i>', $url, [
                'class' => 'btn-action fs-5',
                'title' => 'Просмотр',
            ]);
        },
        'update' => function ($url, $model, $key) {
            return Html::a('<i class="bi bi-pencil"></i>', $url, [
                'class' => 'btn-action fs-5 ms-1',
                'title' => 'Редактировать',
            ]);
        },
    ],
            ],
        ],
    ]); ?>


</div>
