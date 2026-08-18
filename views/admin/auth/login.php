<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Вход администратора';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
<?= $form->field($model, 'password')->passwordInput() ?>

<div class="form-group">
    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
