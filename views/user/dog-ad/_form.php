<?php
// views/user/dog-ad/_form.php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Dog $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="dog-ad-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Информация о продаже</h5>
        </div>
        <div class="card-body">
            <?= $form->field($model, 'is_for_sale')->checkbox() ?>

            <?= $form->field($model, 'price')->textInput([
                'type' => 'number',
                'min' => 0,
                'placeholder' => 'Укажите цену'
            ]) ?>

            <?= $form->field($model, 'sale_contacts')->textarea([
                'rows' => 2,
                'placeholder' => 'Контактная информация для покупателей'
            ]) ?>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Информация о вязке</h5>
        </div>
        <div class="card-body">
            <?= $form->field($model, 'is_for_mating')->checkbox() ?>

            <?= $form->field($model, 'mating_contacts')->textarea([
                'rows' => 2,
                'placeholder' => 'Контактная информация для владельцев кобелей/сук'
            ]) ?>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Дополнительная информация</h5>
        </div>
        <div class="card-body">
            <?= $form->field($model, 'additional_info')->textarea([
                'rows' => 3,
                'placeholder' => 'Дополнительная информация о собаке'
            ]) ?>

            <?= $form->field($model, 'is_ad_active')->dropDownList([
                0 => 'Скрыто',
                1 => 'Активно'
            ], [
                'prompt' => 'Выберите статус объявления'
            ]) ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>