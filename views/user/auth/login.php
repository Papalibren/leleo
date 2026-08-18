<?php
// views/user/auth/login.php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Авторизация';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h1 class="card-title text-center mb-0"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label fw-bold'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ],
                    ]); ?>

                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'email')->input('email', [
                                'placeholder' => 'your@email.com'
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'password')->passwordInput([
                                'placeholder' => 'Введите ваш пароль'
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'rememberMe')->checkbox([
                                'class' => 'form-check-input',
                                'labelOptions' => ['class' => 'form-check-label']
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= Html::submitButton('Войти', [
                                'class' => 'btn btn-success btn-lg w-100'
                            ]) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6 text-center mb-2">
                            <?= Html::a('Забыли пароль?', ['/user/auth/request-password-reset'], [
                                'class' => 'text-success'
                            ]) ?>
                        </div>
                        <div class="col-md-6 text-center">
                            <?= Html::a('Регистрация', ['/user/auth/register'], [
                                'class' => 'text-success fw-bold'
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>