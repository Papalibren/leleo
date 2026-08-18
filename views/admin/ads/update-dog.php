<?php
// views/admin/ads/update-dog.php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Dog $model */

$this->title = 'Редактировать объявление: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<div class="ads-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Информация о продаже</h5>
        </div>
        <div class="card-body">
            <?= $form->field($model, 'is_for_sale')->checkbox() ?>
            <?= $form->field($model, 'price')->textInput(['type' => 'number']) ?>
            <?= $form->field($model, 'sale_contacts')->textarea(['rows' => 3]) ?>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Информация о вязке</h5>
        </div>
        <div class="card-body">
            <?= $form->field($model, 'is_for_mating')->checkbox() ?>
            <?= $form->field($model, 'mating_contacts')->textarea(['rows' => 3]) ?>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Дополнительная информация</h5>
        </div>
        <div class="card-body">
            <?= $form->field($model, 'additional_info')->textarea(['rows' => 3]) ?>
            <?= $form->field($model, 'is_ad_active')->dropDownList([
                0 => 'Неактивно',
                1 => 'Активно'
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>