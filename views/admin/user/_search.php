<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\admin\UserSearch $model */
?>

<div class="user-search mb-3">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'row g-2 align-items-end'],
    ]); ?>

    <div class="col-auto">
        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>
    </div>
    <div class="col-auto">
        <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Фамилия'])->label(false) ?>
    </div>
    <div class="col-auto">
        <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'Имя'])->label(false) ?>
    </div>
    <div class="col-auto">
        <?= $form->field($model, 'city')->textInput(['placeholder' => 'Город'])->label(false) ?>
    </div>
    <div class="col-auto">
        <?= $form->field($model, 'is_advanced')->dropDownList(
            [1 => 'Продвинутый', 0 => 'Обычный'],
            ['prompt' => 'Любой тип']
        )->label(false) ?>
    </div>
    <div class="col-auto">
        <?= $form->field($model, 'is_active')->dropDownList(
            [1 => 'Активен', 0 => 'Заблокирован'],
            ['prompt' => 'Любой статус']
        )->label(false) ?>
    </div>

    <div class="col-auto mb-3">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Сбросить', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>