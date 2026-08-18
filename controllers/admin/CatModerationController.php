<?php
// controllers/admin/CatModerationController.php

namespace app\controllers\admin;

use Yii;
use app\models\CatModeration;
use app\models\admin\CatModerationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class CatModerationController extends Controller
{
    public $layout = 'admin';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->is_admin == 1;
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CatModerationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $moderation = $this->findModel($id);
        $cat = $moderation->cat;

        return $this->render('view', [
            'moderation' => $moderation,
            'cat' => $cat,
        ]);
    }

    public function actionApprove($id)
    {
        $moderation = $this->findModel($id);

        if ($moderation->status !== CatModeration::STATUS_PENDING) {
            Yii::$app->session->setFlash('error', 'Эта запись уже была обработана.');
            return $this->redirect(['index']);
        }

        // Применяем изменения
        $cat = $moderation->cat;
        $newData = json_decode($moderation->data_after, true);
        $cat->setAttributes($newData);
        $cat->is_active = 1; // Активируем кошку

        if ($cat->save()) {
            // Обновляем историю
            \app\models\CatHistory::updateAll(
                [
                    'status' => \app\models\CatHistory::STATUS_APPROVED,
                    'moderated_by' => Yii::$app->user->id,
                    'moderated_at' => date('Y-m-d H:i:s')
                ],
                ['cat_id' => $cat->id, 'status' => \app\models\CatHistory::STATUS_PENDING]
            );

            $moderation->status = CatModeration::STATUS_APPROVED;
            $moderation->moderated_by = Yii::$app->user->id;
            $moderation->moderated_at = date('Y-m-d H:i:s');
            $moderation->save();

            Yii::$app->session->setFlash('success', 'Изменения успешно приняты.');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка при применении изменений.');
        }

        return $this->redirect(['index']);
    }

    public function actionReject($id)
    {
        $moderation = $this->findModel($id);

        if ($moderation->status !== CatModeration::STATUS_PENDING) {
            Yii::$app->session->setFlash('error', 'Эта запись уже была обработана.');
            return $this->redirect(['index']);
        }

        $moderation->status = CatModeration::STATUS_REJECTED;
        $moderation->moderated_by = Yii::$app->user->id;
        $moderation->moderated_at = date('Y-m-d H:i:s');
        $moderation->save();

        // Отмечаем историю как отклоненную
        \app\models\CatHistory::updateAll(
            [
                'status' => \app\models\CatHistory::STATUS_REJECTED,
                'moderated_by' => Yii::$app->user->id,
                'moderated_at' => date('Y-m-d H:i:s')
            ],
            ['cat_id' => $moderation->cat_id, 'status' => \app\models\CatHistory::STATUS_PENDING]
        );

        Yii::$app->session->setFlash('success', 'Изменения отклонены.');

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = CatModeration::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запись на модерации не найдена.');
    }
}