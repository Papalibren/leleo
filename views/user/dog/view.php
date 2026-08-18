<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

\yii\web\YiiAsset::register($this);

$this->title = $model->name;

?>
<div class="dog-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'translit',
            'breed',
            'birth_date',
            'gender',
            [
                'attribute' => 'color_id',
                'value' => $model->color ? $model->color->name : 'не указан',
            ],
            'pedigree_number',
            'chip',
            [
                'attribute' => 'is_for_mating',
                'value' => $model->is_for_mating ? 'Да' : 'Нет',
            ],
            'mating_contacts:ntext',
            [
                'attribute' => 'is_for_sale',
                'value' => $model->is_for_sale ? 'Да' : 'Нет',
            ],
            'sale_contacts:ntext',
            'price',
            [
                'attribute' => 'owner_id',
                'format' => 'raw',
                'value' => function($model) {
                    if (!$model->owner) return 'не указан';

                    if ($model->owner->nursery) {
                        return Html::a(
                            Html::encode($model->owner->gfn() . ' (' . $model->owner->nursery->title . ')'),
                            ['/nursery/view', 'id' => $model->owner->nursery->id]
                        );
                    } else {
                        return Html::encode($model->owner->gfn());
                    }
                },
            ],
            [
                'attribute' => 'breeder_id',
                'format' => 'raw',
                'value' => function($model) {
                    if (!$model->breeder) return 'не указан';

                    if ($model->breeder->nursery) {
                        return Html::a(
                            Html::encode($model->breeder->gfn() . ' (' . $model->breeder->nursery->title . ')'),
                            ['/nursery/view', 'id' => $model->breeder->nursery->id]
                        );
                    } else {
                        return Html::encode($model->breeder->gfn());
                    }
                },
            ],
            [
                'label' => 'Отец',
                'format' => 'raw',
                'value' => $model->father
                    ? Html::a(
                        Html::encode($model->father->name),
                        ['dogs/view', 'id' => $model->father->id, 'translit' => $model->father->translit]
                    )
                    : 'не указан',
            ],
            [
                'label' => 'Мать',
                'format' => 'raw',
                'value' => $model->mother
                    ? Html::a(
                        Html::encode($model->mother->name),
                        ['dogs/view', 'id' => $model->mother->id, 'translit' => $model->mother->translit]
                    )
                    : 'не указана',
            ],
            'titles:ntext',
            'additional_info:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>

<?= \app\widgets\AncestorsTableWidgetDog::widget([
    'model' => $model,
]) ?>