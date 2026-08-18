<?php
// views/user/auth/reset-password.php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Сброс пароля';
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
                    <p class="text-muted">Введите новый пароль для вашего аккаунта.</p>

                    <?php $form = ActiveForm::begin([
                        'id' => 'reset-password-form',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label fw-bold'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback d-block'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'password')->passwordInput([
                        'placeholder' => 'Новый пароль (минимум 6 символов)'
                    ]) ?>

                    <?= $form->field($model, 'password_repeat')->passwordInput([
                        'placeholder' => 'Повторите новый пароль'
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Сохранить пароль', ['class' => 'btn btn-success btn-lg w-100']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>