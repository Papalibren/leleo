<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\View;

/** @var yii\web\View $this */
/** @var app\models\Cat $model */

$this->title = $model->name;

\yii\web\YiiAsset::register($this);







?>
<div class="cat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <h3>Фотографии</h3>
    <div class="row">
        <?php foreach ($model->catPhotos as $photo): ?>
            <div class="col-md-3">
                <?= Html::img(Yii::getAlias('@web') . '/' . $photo->image_path, ['class' => 'img-thumbnail', 'style' => 'max-width: 100%; height: auto;']) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <h3 class="mt-4">Документы</h3>
    <ul>
        <?php foreach ($model->catDocuments as $doc): ?>
            <li>
                <?= Html::a(
                    "Документ",
                    Yii::getAlias('@web') . '/' . $doc->document_path,
                    ['target' => '_blank', 'download' => true]
                ) ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'translit',
            [
                'attribute' => 'is_active',
                'format' => 'raw',
                'value' => Html::a(
                    $model->is_active ? 'Активна, исключить с сайта' : 'Неактивна, пустить на сайт',
                    ['toggle-status', 'id' => $model->id],
                    [
                        'class' => $model->is_active ? 'btn btn-success' : 'btn btn-warning',
                        'data' => ['method' => 'post']
                    ]
                ),
            ],
            //'breed',
            'birth_date',
            //'gender',
            [
                'attribute' => 'color_id',
                'value' => $model->color ? $model->color->name : null,
            ],
            'pedigree_number',
            'chip',
            //'is_for_mating',
            //'mating_contacts:ntext',
            //'is_for_sale',
            //'sale_contacts:ntext',
            //'price',
            //'owner_id',
            //'breeder_id',
            [
                'label' => 'Отец',
                'format' => 'raw',
                'value' => $model->father
                    ? Html::a(
                        Html::encode($model->father->name),
                        ['cats/view', 'id' => $model->father->id, 'translit' => $model->father->translit]
                    )
                    : 'не указан',
            ],
            [
                'label' => 'Мать',
                'format' => 'raw',
                'value' => $model->mother
                    ? Html::a(
                        Html::encode($model->mother->name),
                        ['cats/view', 'id' => $model->mother->id, 'translit' => $model->mother->translit]
                    )
                    : 'не указана',
            ],
            //'titles:ntext',
            //'additional_info:ntext',
            'created_at',
            //'updated_at',

        ],
    ]) ?>

</div>
<?= \app\widgets\AncestorsTableWidget::widget([
    'model' => $model,
]) ?>