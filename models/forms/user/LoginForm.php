<?php
namespace app\models\forms\user;

use Yii;
use yii\base\Model;
use app\models\User;

class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня',
        ];
    }

    public function validatePassword($attribute)
    {
        $user = $this->getUser();

        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Неверный логин или пароль.');
        }
    }

    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();

            if ($this->rememberMe) {
                if (empty($user->cookie_token)) {
                    $user->generateAuthToken();
                }
                $duration = 3600 * 24 * 30; // 30 дней
            } else {
                $duration = 0;
            }

            return Yii::$app->user->login($user, $duration);
        }

        return false;
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }
        return $this->_user;
    }
}