<?php
// views/user/auth/register.php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h1 class="card-title text-center mb-0"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'register-form',
                        'enableClientValidation' => true,
                        'enableAjaxValidation' => false,
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label fw-bold'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback d-block'],
                        ],
                    ]); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->input('email', [
                                'placeholder' => 'your@email.com'
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'password')->passwordInput([
                                'placeholder' => 'Не менее 6 символов'
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'password_repeat')->passwordInput([
                                'placeholder' => 'Повторите пароль'
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'last_name')->textInput([
                                'placeholder' => 'Фамилия'
                            ]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'first_name')->textInput([
                                'placeholder' => 'Имя'
                            ]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'middle_name')->textInput([
                                'placeholder' => 'Отчество (необязательно)'
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'country')->textInput([
                                'placeholder' => 'Страна'
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'city')->textInput([
                                'placeholder' => 'Город'
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'agree_terms')->checkbox([
                                'template' => "<div class=\"form-check\">{input} {label}</div>\n{error}",
                                'label' => 'Я принимаю <a href="' . Url::to(['/site/privacy-policy']) . '" class="text-success" target="_blank">политику конфиденциальности</a>',
                                'class' => 'form-check-input',
                                'labelOptions' => ['class' => 'form-check-label']
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= Html::submitButton('Зарегистрироваться', [
                                'class' => 'btn btn-success btn-lg w-100'
                            ]) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <hr class="my-4">

                    <div class="text-center">
                        <p>Уже есть аккаунт? <?= Html::a('Войти', ['/user/auth/login'], [
                            'class' => 'text-success fw-bold'
                        ]) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>