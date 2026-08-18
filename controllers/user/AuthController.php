<?php

namespace app\controllers\user;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\forms\user\LoginForm;
use app\models\forms\user\RegisterForm;
use app\models\forms\user\PasswordResetRequestForm;
use app\models\forms\user\ResetPasswordForm;
use yii\web\BadRequestHttpException;
use app\models\User;

class AuthController extends Controller
{
    public $layout = 'auth';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'register', 'request-password-reset', 'reset-password'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirectToUserPanel();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                Yii::$app->session->setFlash('success', 'Добро пожаловать!');
                return $this->redirectToUserPanel();
            } else {
                Yii::$app->session->setFlash('error', 'Неверный email или пароль.');
            }
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Перенаправляет пользователя в соответствующую панель в зависимости от роли
     */
    private function redirectToUserPanel()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        /** @var User $user */
        $user = Yii::$app->user->identity;

        if ($user->isAdmin()) {
            return $this->redirect(['/admin/home']); // Перенаправляем в админ-панель
        } else {
            return $this->redirect(['/user/home']); // Перенаправляем в личный кабинет пользователя
        }
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirectToUserPanel();
        }

        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->register()) {
                Yii::$app->session->setFlash('success', 'Регистрация успешно завершена');
                return $this->redirectToUserPanel();
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при регистрации. Проверьте введенные данные.');
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('success', 'Вы успешно вышли из системы.');
        return $this->goHome();
    }

    public function actionRequestPasswordReset()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirectToUserPanel();
        }

        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                // Временно: получаем пользователя для отладки
                $user = User::findOne([
                    'is_active' => 1,
                    'email' => $model->email,
                ]);

                if ($user && $user->password_reset_token) {
                    // Формируем ссылку для сброса пароля
                    $resetLink = Yii::$app->urlManager->createAbsoluteUrl([
                        '/user/auth/reset-password',
                        'token' => $user->password_reset_token
                    ]);

                    // Выводим ссылку во флеш-сообщение
                    Yii::$app->session->setFlash(
                        'success',
                        'Инструкции по восстановлению пароля отправлены на вашу почту. ' .
                            'Для тестирования: <a href="' . $resetLink . '" target="_blank">' .
                            'Ссылка для сброса пароля</a>'
                    );
                } else {
                    Yii::$app->session->setFlash('success', 'Инструкции по восстановлению пароля отправлены на вашу почту.');
                }

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось отправить email. Попробуйте позже.');
            }
        }

        return $this->render('request-password-reset', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirectToUserPanel();
        }

        try {
            $model = new ResetPasswordForm($token);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->resetPassword()) {
                Yii::$app->session->setFlash('success', 'Пароль успешно изменен. Теперь вы можете войти с новым паролем.');
                return $this->redirect(['login']);
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось изменить пароль.');
            }
        }

        return $this->render('reset-password', [
            'model' => $model,
        ]);
    }
}