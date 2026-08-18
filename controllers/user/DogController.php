<?php

namespace app\controllers\user;

use app\models\Dog;
use app\models\DogDocuments;
use app\models\DogPhotos;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\web\Response;
use app\models\DogColor;


class DogController extends Controller
{
    public $layout = 'user';

    /**
     * @inheritDoc
     */
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
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'create', 'update', 'view', 'create-parent'],
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'create', 'create-parent', 'update', 'view'],
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all dog models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Dog::find()->where(['owner_id' => Yii::$app->user->id]),

            'pagination' => [
                'pageSize' => 8
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single dog model.
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
     * Creates a new dog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // controllers/user/DogController.php
    public function actionCreateParent($type, $child_id)
    {
        $model = new Dog();
        $photos = new DogPhotos();
        $child = Dog::findOne($child_id);

        if (!$child) {
            throw new NotFoundHttpException('Собака не найдена');
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->user_added_id = Yii::$app->user->id;
                $model->is_active = 0; // На модерации

                if ($model->save()) {
                    // Загрузка фотографий
                    $photos->imageFiles = UploadedFile::getInstances($photos, 'imageFiles');
                    $photos->dog_id = $model->id;

                    if ($photos->uploadMultiple()) {
                        Yii::$app->session->setFlash('success', 'Фотографии успешно загружены');
                    }

                    // Обновляем связь с ребенком
                    if ($type === 'father') {
                        $child->father_id = $model->id;
                    } else {
                        $child->mother_id = $model->id;
                    }

                    if ($child->save()) {
                        Yii::$app->session->setFlash('success', 'Родитель успешно добавлен и связь установлена');
                        return $this->redirect(['view', 'id' => $child->id]);
                    } else {
                        Yii::$app->session->setFlash('error', 'Ошибка при установке связи с ребенком');
                    }
                }
            }
        } else {
            $model->loadDefaultValues();

            // Устанавливаем породу такую же как у ребенка
            if ($child->breed) {
                $model->breed = $child->breed;
            }
        }

        return $this->render('create-parent', [
            'model' => $model,
            'photos' => $photos,
            'type' => $type,
            'child_id' => $child_id,
        ]);
    }

    public function actionCreate()
    {

        $model = new Dog();
        $photos = new DogPhotos();
        $documents = new DogDocuments();

        //du($model -> getAttributes());

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                if ($model->is_for_sale == 1 ||  $model->is_for_mating == 1) {
                    $model->is_ad_active = 1;
                    $model->save(false);
                }
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
                return $this->redirect(['view', 'id' => $model->id]);
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

    /**
     * Updates an existing dog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $photos = new dogPhotos();
        $documents = new dogDocuments();

        $existingPhotos = dogPhotos::find()->where(['dog_id' => $id])->all();


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

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
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'photos' => $photos,
            'documents' => $documents,
            'existingPhotos' => $existingPhotos,
        ]);
    }

    public function actionDeletePhoto()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('key');
        $dog_id = Yii::$app->request->post('dog_id');

        $photo = dogPhotos::findOne(['id' => $id, 'dog_id' => $dog_id]);
        if ($photo) {
            $filePath = Yii::getAlias('@webroot/' . $photo->image_path);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            $photo->delete();
            return ['success' => true];
        }

        throw new NotFoundHttpException("Файл не найден");
    }

    public function actionSortPhotos()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $order = Yii::$app->request->post('sortData'); // kartik передаёт сюда массив [key => newSortOrder]

        if (!is_array($order)) {
            return ['success' => false, 'message' => 'Данные не получены'];
        }

        foreach ($order as $key => $sortOrder) {
            $photo = \app\models\dogPhotos::findOne($key);
            if ($photo !== null) {
                $photo->sort_order = $sortOrder;
                $photo->save(false);
            }
        }

        return ['success' => true];
    }


    /**
     * Deletes an existing dog model.
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
     * Finds the dog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return dog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = dog::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionGetColors($breed)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $colors = DogColor::getColorsByBreed($breed);

        return $colors;
    }
}
