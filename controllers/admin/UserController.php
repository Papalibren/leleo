<?php

namespace app\controllers\admin;

use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public $layout = 'admin';
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['is_admin' => 0]),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        $model->is_active = 1;

        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'Пользователь разблокирован.');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка при разблокировке.');
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDeactivate($id)
    {
        $model = $this->findModel($id);
        $model->is_active = 0;

        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'Пользователь заблокирован.');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка при блокировке.');
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionMakeAdvanced($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $isForever = (bool) Yii::$app->request->post('is_forever');

            if ($isForever) {
                $model->is_advanced = 1;
                $model->advanced_until = null; // null = бессрочно

                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Пользователю выдан статус "Продвинутый" бессрочно.');
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка при сохранении.');
                }

                return $this->redirect(['view', 'id' => $id]);
            }

            $model->load($this->request->post());
            $date = $model->advanced_until;

            if ($date && strtotime($date)) {
                $model->is_advanced = 1;
                $model->advanced_until = date('Y-m-d', strtotime($date));

                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Пользователь получил статус "Продвинутый".');
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка при сохранении.');
                }

                return $this->redirect(['view', 'id' => $id]);
            }

            Yii::$app->session->setFlash('error', 'Укажите корректную дату либо выберите вариант "Навсегда".');
        }

        return $this->render('set-advanced-date', [
            'model' => $model,
        ]);
    }

    public function actionMakeBasic($id)
    {
        $model = $this->findModel($id);
        $model->is_advanced = 0;
        $model->advanced_until = null;

        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'Пользователь переведён в обычный статус.');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка при обновлении.');
        }

        return $this->redirect(['view', 'id' => $id]);
    }
}
