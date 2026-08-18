<?php
// views/user/cat-ad/index.php (полная версия)

use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Мои объявления по кошкам';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cat-ad-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'breed',
            'pedigree_number',
            [
                'attribute' => 'is_for_sale',
                'format' => 'boolean',
                'label' => 'Для продажи',
            ],
            [
                'attribute' => 'is_for_mating',
                'format' => 'boolean',
                'label' => 'Для вязки',
            ],
            'price:currency',
            [
                'attribute' => 'is_ad_active',
                'format' => 'boolean',
                'label' => 'Активно',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('Редактировать', $url, ['class' => 'btn btn-sm btn-primary']);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'update') {
                        return ['/user/cat-ad/update', 'id' => $model->id];
                    }
                    return '';
                },
            ],
        ],
    ]) ?>
</div>