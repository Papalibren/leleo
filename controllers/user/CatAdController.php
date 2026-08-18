<?php
// controllers/user/CatAdController.php

namespace app\controllers\user;

use app\models\Cat;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\AccessControl;

/**
 * CatAdController implements the CRUD actions for Cat model.
 */
class CatAdController extends Controller
{
    public $layout = 'user';

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // Проверяем доступ для всех действий контроллера
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->is_advanced !== 1) {
            // Устанавливаем flash-сообщение
            Yii::$app->session->setFlash('warning',
                'Этот раздел доступен только продвинутым пользователям. ' .
                'Для получения доступа приобретите продвинутый аккаунт.'
            );

            // Редиректим в личный кабинет
            return $this->redirect(['/user/home'])->send();
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Cat::find()->where(['owner_id' => Yii::$app->user->id]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Объявление обновлено.');
            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model]);
    }

    protected function findModel($id)
    {
        $model = Cat::findOne(['id' => $id, 'owner_id' => Yii::$app->user->id]);
        if (!$model) {
            throw new NotFoundHttpException('Кошка не найдена или доступ запрещён.');
        }
        return $model;
    }
}