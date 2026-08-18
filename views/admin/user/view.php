<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model-> gfn();
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view p-2">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?php if ($model->is_active): ?>
            <?= Html::a('Заблокировать', ['deactivate', 'id' => $model->id], [
                'class' => 'btn btn-secondary',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите заблокировать пользователя?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php else: ?>
            <?= Html::a('Разблокировать', ['activate', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите разблокировать пользователя?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>

        <?php if ($model->is_advanced): ?>
            <?= Html::a('Сделать обычным', ['make-basic', 'id' => $model->id], [
                'class' => 'btn btn-outline-primary',
            ]) ?>
        <?php else: ?>
            <?= Html::a('Сделать продвинутым', ['make-advanced', 'id' => $model->id], [
                'class' => 'btn btn-outline-info',
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'email:email',
            'first_name',
            'last_name',
            'middle_name',
            'country',
            'city',
            'is_admin',
            [
                'attribute' => 'is_active',
                'value' => $model->is_active ? 'Активен' : 'Заблокирован',
            ],
            [
                'attribute' => 'is_advanced',
                'value' => $model->is_advanced ? 'Продвинутый' : 'Обычный',
            ],
            'advanced_until',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
