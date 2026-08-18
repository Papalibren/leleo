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

    <p>Выберите дату, до которой пользователь будет иметь статус "Продвинутый".</p>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'advanced_until')->input('date') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отмена', ['view', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
