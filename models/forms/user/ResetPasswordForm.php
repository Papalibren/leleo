<?php
// models/forms/user/ResetPasswordForm.php

namespace app\models\forms\user;

use Yii;
use yii\base\Model;
use app\models\User;

class ResetPasswordForm extends Model
{
    public $password;
    public $password_repeat;
    private $_user;

    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new \InvalidArgumentException('Токен сброса пароля не может быть пустым.');
        }

        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new \InvalidArgumentException('Неверный токен сброса пароля.');
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['password', 'password_repeat'], 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Новый пароль',
            'password_repeat' => 'Повторите пароль',
        ];
    }

    public function resetPassword()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->_user;
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        $user->password_reset_token = null;
        $user->password_reset_expires_at = null;

        return $user->save(false); // false чтобы пропустить валидацию
    }

    public function getUser()
    {
        return $this->_user;
    }
}