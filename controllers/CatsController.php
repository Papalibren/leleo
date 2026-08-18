<?php

namespace app\controllers;

use app\models\Announcements;
use app\models\Cat;
use app\models\CatDocuments;
use app\models\CatPhotos;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\AccessControl;


class CatsController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['edit'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['edit'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionIndex($letter = null, $search = null)
    {
        $query = Cat::find()->where(['is_active' => 1]);

        if ($letter) {
            $query->andWhere(['LIKE', 'name', $letter . '%', false]);
        }

        if ($search) {
            $query->andWhere(['LIKE', 'name', $search]);
        }

        $query->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20, // 20 кошек на страницу
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'letter' => $letter,
            'search' => $search,
        ]);
    }



    public function actionView($id, $translit = null)
    {
        $model = Cat::findOne($id);


        if ($model === null) {
            throw new NotFoundHttpException("Кошка не найдена");
        }

        // Проверка на соответствие транслита
        if ($translit !== null && $model->translit !== $translit) {
            // редирект на правильный URL
            return $this->redirect(['view', 'id' => $model->id, 'translit' => $model->translit], 301);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);
        $model->is_active = 0;
        $photos = new CatPhotos();
        $documents = new CatDocuments();

        $existingPhotos = CatPhotos::find()->where(['cat_id' => $id])->all();


        if ($this->request->isPost) {

            if ($model->load($this->request->post()) && $model->save()) {

                $photos->imageFiles = UploadedFile::getInstances($photos, 'imageFiles');
                $photos->cat_id = $model->id;
                $documents->documentFiles = UploadedFile::getInstances($documents, 'documentFiles');
                $documents->cat_id = $model->id;

                if ($photos->uploadMultiple()) {
                    Yii::$app->session->setFlash('success', 'Фотографии успешно загружены');
                }
                if ($documents->uploadMultiple()) {
                    Yii::$app->session->setFlash('success', 'Данные загружены и отправлены на модерацию');
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('edit', [
            'model' => $model,
            'photos' => $photos,
            'documents' => $documents,
            'existingPhotos' => $existingPhotos,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Cat::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
