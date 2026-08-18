<?php
// mail/passwordReset.php

use yii\helpers\Html;

/** @var \app\models\User $user */
?>
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
    <h2 style="color: #28a745;">Восстановление пароля</h2>

    <p>Вы запросили восстановление пароля для вашего аккаунта в <?= Yii::$app->name ?>.</p>

    <p>Для сброса пароля перейдите по ссылке:</p>

    <p style="text-align: center; margin: 30px 0;">
        <?= Html::a('Сбросить пароль', Yii::$app->urlManager->createAbsoluteUrl([
            '/user/auth/reset-password',
            'token' => $user->password_reset_token
        ]), [
            'style' => 'background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;'
        ]) ?>
    </p>

    <p>Если вы не запрашивали восстановление пароля, просто проигнорируйте это письмо.</p>

    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">

    <p style="color: #6c757d; font-size: 12px;">
        Ссылка действительна в течение 1 часа.<br>
        Это автоматическое сообщение. Пожалуйста, не отвечайте на него.
    </p>
</div>