<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * @property int $id
 * @property string $email
 * @property string $password_hash
 * @property string $first_name
 * @property string $last_name
 * @property string|null $middle_name
 * @property string $country
 * @property string $city
 * @property int|null $is_admin
 * @property int|null $is_active
 * @property int|null $is_advanced
 * @property string|null $advanced_until
 * @property string|null $cookie_token
 * @property string|null $password_reset_token
 * @property string|null $password_reset_expires_at
 * @property int $accept_privacy_policy
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $password;
    public $password_repeat;
    public $agree_terms;

    const SCENARIO_OTHER = 'other';
    const SCENARIO_REGISTER = 'register';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_OTHER] = ['first_name', 'last_name', 'country', 'city'];
        $scenarios[self::SCENARIO_REGISTER] = ['email', 'password_hash', 'first_name', 'last_name', 'middle_name', 'country', 'city', 'is_active', 'is_admin', 'accept_privacy_policy'];
        return $scenarios;
    }

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'country', 'city'], 'required', 'on' => self::SCENARIO_OTHER],
            [['email', 'first_name', 'last_name', 'country', 'city', 'password', 'password_repeat', 'agree_terms'], 'required', 'on' => self::SCENARIO_REGISTER],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['is_admin', 'is_active', 'is_advanced', 'accept_privacy_policy'], 'integer'],
            [['advanced_until', 'password_reset_expires_at', 'created_at', 'updated_at'], 'safe'],
            [['email'], 'string', 'max' => 150],
            [['password_hash', 'first_name', 'last_name', 'middle_name', 'country', 'city', 'cookie_token', 'password_reset_token'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => 6],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
            [['agree_terms'], 'compare', 'compareValue' => 1, 'message' => 'Вы должны принять политику конфиденциальности'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
            'password_hash' => 'Password Hash',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'middle_name' => 'Отчество',
            'country' => 'Страна',
            'city' => 'Город',
            'is_admin' => 'Администратор',
            'is_active' => 'Активен',
            'is_advanced' => 'Продвинутый профиль',
            'advanced_until' => 'Продвинутый до',
            'cookie_token' => 'Cookie Token',
            'password_reset_token' => 'Password Reset Token',
            'password_reset_expires_at' => 'Password Reset Expires At',
            'accept_privacy_policy' => 'Принимаю политику конфиденциальности',
            'agree_terms' => 'Я принимаю условия',
            'created_at' => 'Дата регистрации',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->accept_privacy_policy = 1;
                $this->is_active = 1;
                $this->is_admin = 0;
            }
            return true;
        }
        return false;
    }

    // --------------- Аутентификация ----------------

    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id, 'is_active' => 1]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['cookie_token' => $token, 'is_active' => 1]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->cookie_token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findByEmail($email)
    {
        return self::findOne(['email' => $email, 'is_active' => 1]);
    }

    public function validatePassword($password)
    {
        if (empty($this->password_hash) || !is_string($this->password_hash)) {
            return false;
        }
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    // --------------- Сброс пароля ----------------

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
        $this->password_reset_expires_at = date('Y-m-d H:i:s', time() + 3600);
    }


    public static function findByPasswordResetToken($token)
    {
        if (empty($token) || !is_string($token)) {
            return null;
        }

        // Yii автоматически декодирует URL параметры, но на всякий случай
        $token = urldecode($token);

        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'is_active' => 1
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token) || !is_string($token) || strpos($token, '_') === false) {
            return false;
        }


        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'] ?? 3600;

        return $timestamp + $expire >= time();
    }

    public function resetPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        $this->password_reset_token = null;
        $this->password_reset_expires_at = null;
        return $this->save(false);
    }

    // --------------- Генерация cookie-токена ----------------

    public function generateAuthToken()
    {
        $this->cookie_token = Yii::$app->security->generateRandomString();
        return $this->save(false);
    }

    // --------------- Роль ----------------

    public function getRole()
    {
        return $this->is_admin ? 'admin' : 'breeder';
    }

    public function isAdmin()
    {
        return (bool) $this->is_admin;
    }

    public function isAdvanced()
    {
        return (bool) $this->is_advanced;
    }

    public function isBreeder()
    {
        return !$this->is_admin;
    }

    public function gfn()
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    public function getStatusView()
    {
        if ($this->isAdvanced()) {
            $until = $this->advanced_until
                ? 'до ' . $this->advanced_until
                : 'бессрочно';
            return '<span class="text-danger">Продвинутый, ' . $until . '</span>';
        } else {
            return '<span class="text-info">Обычный' . '</span>';
        }
    }

    public function getNursery()
    {
        return $this->hasOne(Nursery::class, ['breeder_id' => 'id']);
    }

    public function sendRegistrationEmail($plainPassword)
    {
        try {
            return Yii::$app->mailer->compose('register', [
                'user' => $this,
                'plainPassword' => $plainPassword,
            ])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setTo($this->email)
                ->setSubject('Регистрация на сайте ' . Yii::$app->name)
                ->send();
        } catch (\Exception $e) {
            Yii::error('Ошибка отправки email при регистрации: ' . $e->getMessage());
            return false;
        }
    }

    public function sendPasswordResetEmail()
    {
        $resetLink = Yii::$app->urlManager->createAbsoluteUrl([
            '/user/auth/reset-password',
            'token' => $this->password_reset_token // Yii автоматически закодирует
        ]);

        return Yii::$app->mailer->compose('passwordReset', [
            'user' => $this,
            'resetLink' => $resetLink
        ])
            ->setFrom([Yii::$app->params['supportEmail'] => 'Администрация сайта'])
            ->setTo($this->email)
            ->setSubject('Восстановление пароля')
            ->send();
    }
}
