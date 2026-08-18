<?php
// models/forms/user/PasswordResetRequestForm.php

namespace app\models\forms\user;

use Yii;
use yii\base\Model;
use app\models\User;

class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => User::class,
                'filter' => ['is_active' => 1],
                'message' => 'Пользователь с таким email не найден или неактивен.'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
        ];
    }

    public function sendEmail()
    {
        $user = User::findOne([
            'is_active' => 1,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return $user->sendPasswordResetEmail();
    }
}