<?php
// views/nursery/_item.php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var \app\models\Nursery $model */
?>

<div class="card h-100">
    <div class="card-body">
        <div class="text-center mb-3">
            <?php if ($model->photo): ?>
                <img src="/<?= Html::encode($model->photo) ?>" alt="<?= Html::encode($model->title) ?>" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
            <?php else: ?>
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                    <span class="text-muted">Нет логотипа</span>
                </div>
            <?php endif; ?>
        </div>

        <h5 class="card-title"><?= Html::encode($model->title) ?></h5>

        <p class="card-text">
            <strong>Заводчик:</strong> <?= $model->breeder ? Html::encode($model->breeder->gfn()) : 'не указан' ?><br>
            <strong>Страна:</strong> <?= $model->country ? Html::encode($model->country) : 'не указана' ?><br>
            <strong>Город:</strong> <?= $model->city ? Html::encode($model->city) : 'не указан' ?><br>
            <?php if ($model->phone): ?>
                <strong>Телефон:</strong> <?= Html::encode($model->phone) ?><br>
            <?php endif; ?>
        </p>

        <?php if ($model->url): ?>
            <p class="card-text">
                <small>
                    <a href="<?= Html::encode($model->url) ?>" target="_blank" class="text-muted">
                        <?= Html::encode($model->url) ?>
                    </a>
                </small>
            </p>
        <?php endif; ?>

        <div class="mt-3">
            <?= Html::a('Подробнее', ['view', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= Html::a('Кошки', ['view', 'id' => $model->id, 'animal_type' => 'cats'], ['class' => 'btn btn-outline-secondary btn-sm ms-1']) ?>
            <?= Html::a('Собаки', ['view', 'id' => $model->id, 'animal_type' => 'dogs'], ['class' => 'btn btn-outline-secondary btn-sm ms-1']) ?>
        </div>
    </div>
</div>