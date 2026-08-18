<?php
// mail/register.php

use yii\helpers\Html;

/** @var \app\models\User $user */
/** @var string $plainPassword */
?>
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
    <h2 style="color: #28a745;">Добро пожаловать в <?= Yii::$app->name ?>!</h2>

    <p>Ваша регистрация успешно завершена.</p>

    <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
        <p><strong>Ваши данные для входа:</strong></p>
        <p>Email: <strong><?= Html::encode($user->email) ?></strong></p>
        <p>Пароль: <strong><?= Html::encode($plainPassword) ?></strong></p>
    </div>

    <p>Для входа в систему перейдите по ссылке:</p>
    <p><?= Html::a('Войти в систему', Yii::$app->urlManager->createAbsoluteUrl(['/user/auth/login'])) ?></p>

    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">

    <p style="color: #6c757d; font-size: 12px;">
        Это автоматическое сообщение. Пожалуйста, не отвечайте на него.
    </p>
</div>