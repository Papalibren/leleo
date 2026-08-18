<?php
// views/user/auth/request-password-reset.php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h1 class="card-title text-center mb-0"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="card-body">
                    <p class="text-muted">Введите ваш email, и мы вышлем инструкции для восстановления пароля.</p>

                    <?php $form = ActiveForm::begin([
                        'id' => 'request-password-reset-form',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label fw-bold'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback d-block'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'email')->input('email', [
                        'placeholder' => 'your@email.com'
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success btn-lg w-100']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <hr class="my-4">

                    <div class="text-center">
                        <p><?= Html::a('Войти', ['/user/auth/login'], ['class' => 'text-success']) ?></p>
                        <p>Нет аккаунта? <?= Html::a('Зарегистрироваться', ['/user/auth/register'], ['class' => 'text-success fw-bold']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>