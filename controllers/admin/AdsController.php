<?php
// controllers/admin/AdsController.php

namespace app\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Cat;
use app\models\Dog;

class AdsController extends Controller
{
    public $layout = 'admin';

    public function actionIndex()
    {
        $searchModel = new \app\models\search\AdsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($type, $id)
    {
        if ($type === 'cat') {
            $model = Cat::findOne($id);
            $view = 'view-cat';
        } else {
            $model = Dog::findOne($id);
            $view = 'view-dog';
        }

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Объявление не найдено.');
        }

        return $this->render($view, [
            'model' => $model,
        ]);
    }

    public function actionUpdate($type, $id)
    {
        if ($type === 'cat') {
            $model = Cat::findOne($id);
            $view = 'update-cat';
        } else {
            $model = Dog::findOne($id);
            $view = 'update-dog';
        }

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Объявление не найдено.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Объявление обновлено.');
            return $this->redirect(['index']);
        }

        return $this->render($view, [
            'model' => $model,
        ]);
    }
}