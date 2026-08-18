<?php
namespace app\models\forms\user;

use Yii;
use yii\base\Model;
use app\models\User;

class RegisterForm extends Model
{
    public $email;
    public $password;
    public $password_repeat;
    public $first_name;
    public $last_name;
    public $middle_name;
    public $country;
    public $city;
    public $agree_terms;

    public function rules()
    {
        return [
            [['email', 'password', 'password_repeat', 'first_name', 'last_name', 'country', 'city', 'agree_terms'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот email уже занят'],
            ['password', 'string', 'min' => 6, 'message' => 'Пароль должен содержать минимум 6 символов'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
            ['agree_terms', 'compare', 'compareValue' => 1, 'message' => 'Вы должны принять политику конфиденциальности'],
            [['first_name', 'last_name', 'middle_name', 'country', 'city'], 'string', 'max' => 255],
            [['middle_name'], 'default', 'value' => null],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'middle_name' => 'Отчество',
            'country' => 'Страна',
            'city' => 'Город',
            'agree_terms' => 'Я принимаю условия политики конфиденциальности',
        ];
    }

    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->scenario = User::SCENARIO_REGISTER;
        $user->email = $this->email;
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->middle_name = $this->middle_name;
        $user->country = $this->country;
        $user->city = $this->city;

        if ($user->save()) {
            // Отправляем email с приветствием
            $user->sendRegistrationEmail($this->password);

            // Автоматический вход после регистрации
            return Yii::$app->user->login($user, 3600 * 24 * 30);
        }

        if ($user->hasErrors()) {
            foreach ($user->getErrors() as $attribute => $errors) {
                foreach ($errors as $error) {
                    $this->addError($attribute, $error);
                }
            }
        }

        return false;
    }
}