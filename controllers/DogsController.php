<?php

namespace app\controllers;

use app\models\Dog;
use app\models\DogDocuments;
use app\models\DogPhotos;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\AccessControl;

class DogsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['edit', 'create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['edit', 'create'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($breed = null, $letter = null, $search = null)
    {
        $query = Dog::find()->where(['is_active' => 1]);

        // Фильтр по породе
        if ($breed && in_array($breed, ['Шпиц', 'Тибетский мастиф'])) {
            $query->andWhere(['breed' => $breed]);
        }

        // Фильтр по букве
        if ($letter) {
            $query->andWhere(['LIKE', 'name', $letter . '%', false]);
        }

        // Поиск
        if ($search) {
            $query->andWhere(['LIKE', 'name', $search]);
        }

        $query->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'breed' => $breed,
            'letter' => $letter,
            'search' => $search,
        ]);
    }

    public function actionView($id, $translit = null)
    {
        $model = Dog::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException("Собака не найдена");
        }

        // Проверка на соответствие транслита
        if ($translit !== null && $model->translit !== $translit) {
            return $this->redirect(['view', 'id' => $model->id, 'translit' => $model->translit], 301);
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Dog();
        $photos = new DogPhotos();
        $documents = new DogDocuments();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->user_added_id = Yii::$app->user->id;
                $model->is_active = 0; // На модерации

                if ($model->save()) {
                    // Загрузка фотографий
                    $photos->imageFiles = UploadedFile::getInstances($photos, 'imageFiles');
                    $photos->dog_id = $model->id;

                    // Загрузка документов
                    $documents->documentFiles = UploadedFile::getInstances($documents, 'documentFiles');
                    $documents->dog_id = $model->id;

                    if ($photos->uploadMultiple()) {
                        Yii::$app->session->setFlash('success', 'Фотографии успешно загружены');
                    }

                    if ($documents->uploadMultiple()) {
                        Yii::$app->session->setFlash('success', 'Документы успешно загружены');
                    }

                    Yii::$app->session->setFlash('success', 'Собака добавлена и отправлена на модерацию');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'photos' => $photos,
            'documents' => $documents,
        ]);
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        // Проверка прав: если у собаки есть владелец — редактировать может
        // только он сам (или администратор). Если владельца нет — доступно всем залогиненным.
        $currentUserId = Yii::$app->user->id;
        $isAdmin = !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin();

        if (!empty($model->owner_id) && $model->owner_id != $currentUserId && !$isAdmin) {
            throw new \yii\web\ForbiddenHttpException('У этой собаки есть владелец — редактировать может только он.');
        }

        // Поля кличка/окрас/номер родословной/дата рождения после создания не меняются.
        $model->scenario = Dog::SCENARIO_UPDATE;

        $photos = new DogPhotos();
        $documents = new DogDocuments();

        $existingPhotos = DogPhotos::find()->where(['dog_id' => $id])->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->user_updated_id = Yii::$app->user->id;
                $model->is_active = 0; // Снова на модерацию после редактирования

                if ($model->save()) {
                    $photos->imageFiles = UploadedFile::getInstances($photos, 'imageFiles');
                    $photos->dog_id = $model->id;

                    $documents->documentFiles = UploadedFile::getInstances($documents, 'documentFiles');
                    $documents->dog_id = $model->id;

                    if ($photos->uploadMultiple()) {
                        Yii::$app->session->setFlash('success', 'Фотографии успешно загружены');
                    }

                    if ($documents->uploadMultiple()) {
                        Yii::$app->session->setFlash('success', 'Документы успешно загружены');
                    }

                    Yii::$app->session->setFlash('success', 'Изменения сохранены и отправлены на модерацию');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('edit', [
            'model' => $model,
            'photos' => $photos,
            'documents' => $documents,
            'existingPhotos' => $existingPhotos,
        ]);
    }

    public function actionGetColors($breed)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $colors = \app\models\DogColor::getColorsByBreed($breed);

        return $colors;
    }

    protected function findModel($id)
    {
        if (($model = Dog::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Собака не найдена');
    }
}