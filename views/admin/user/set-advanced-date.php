<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Назначить статус "Продвинутый"';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->gfn(), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-make-advanced">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Выберите вариант: до конкретной даты (например, на 1 год) либо бессрочно.</p>

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-check mb-3">
        <?= Html::checkbox('is_forever', false, [
            'class' => 'form-check-input',
            'id' => 'is-forever-checkbox',
            'onchange' => 'document.getElementById("advanceduntil-field").style.display = this.checked ? "none" : "block";',
        ]) ?>
        <?= Html::label('Выдать навсегда (без ограничения по сроку)', 'is-forever-checkbox', ['class' => 'form-check-label']) ?>
    </div>

    <div id="advanceduntil-field">
        <?= $form->field($model, 'advanced_until')->input('date')->hint('Например, ровно через год от сегодняшней даты — для тарифа "на 1 год".') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отмена', ['view', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
