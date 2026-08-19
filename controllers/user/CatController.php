<?php

namespace app\controllers\user;

use app\models\Cat;
use app\models\CatDocuments;
use app\models\CatPhotos;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * CatController implements the CRUD actions for Cat model.
 */
class CatController extends Controller
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
                    'actions' => [],
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
     * Lists all Cat models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Cat::find()->where(['owner_id' => Yii::$app->user->id]),

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
     * Displays a single Cat model.
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
     * Creates a new Cat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreateParent($type, $child_id)
    {
        $model = new Cat();
        $photos = new CatPhotos();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Устанавливаем флаги перед сохранением
                $model->is_active = 0; // Отправляем на модерацию
                if ($model->is_for_sale == 1 || $model->is_for_mating == 1) {
                    $model->is_ad_active = 1;
                }

                if ($model->save()) {
                    $photos->imageFiles = UploadedFile::getInstances($photos, 'imageFiles');
                    $photos->cat_id = $model->id;

                    if ($photos->uploadMultiple()) {
                        Yii::$app->session->setFlash('success', 'Фотографии успешно загружены');
                    }

                    $childCat = Cat::findOne($child_id);

                    if ($type === 'father') {
                        $childCat->father_id = $model->id;
                        $childCat->save(false);
                    } elseif ($type === 'mother') {
                        $childCat->mother_id = $model->id;
                        $childCat->save(false);
                    }

                    Yii::$app->session->setFlash('success', 'Родитель успешно создан и отправлен на модерацию.');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create-parent', [
            'model' => $model,
            'photos' => $photos,
            'type' => $type,
            'child_id' => $child_id
        ]);
    }

    public function actionCreate()
    {
        $model = new Cat();
        $photos = new CatPhotos();
        $documents = new CatDocuments();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Устанавливаем флаги перед сохранением
                $model->is_active = 0; // Отправляем на модерацию
                if ($model->is_for_sale == 1 || $model->is_for_mating == 1) {
                    $model->is_ad_active = 1;
                }

                if ($model->save()) {
                    $photos->imageFiles = UploadedFile::getInstances($photos, 'imageFiles');
                    $photos->cat_id = $model->id;
                    $documents->documentFiles = UploadedFile::getInstances($documents, 'documentFiles');
                    $documents->cat_id = $model->id;

                    if ($photos->uploadMultiple()) {
                        Yii::$app->session->setFlash('success', 'Фотографии успешно загружены');
                    }
                    if ($documents->uploadMultiple()) {
                        Yii::$app->session->setFlash('success', 'Документы успешно загружены');
                    }

                    Yii::$app->session->setFlash('success', 'Кошка успешно создана и отправлена на модерацию.');
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

    /**
     * Updates an existing Cat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Проверка прав: если у животного есть владелец — редактировать может
        // только он сам (или администратор). Если владельца нет — редактировать
        // может любой залогиненный пользователь (чтобы дополнять недостающую информацию).
        $currentUserId = Yii::$app->user->id;
        $isAdmin = !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin();

        if (!empty($model->owner_id) && $model->owner_id != $currentUserId && !$isAdmin) {
            throw new \yii\web\ForbiddenHttpException('У этого животного есть владелец — редактировать может только он.');
        }

        // Поля кличка/окрас/номер родословной/дата рождения после создания не меняются —
        // сверяются с документами один раз при модерации.
        $model->scenario = Cat::SCENARIO_UPDATE;

        $photos = new CatPhotos();
        $documents = new CatDocuments();

        $existingPhotos = CatPhotos::find()->where(['cat_id' => $id])->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Отправляем на модерацию после изменений
                $model->is_active = 0;
                if ($model->is_for_sale == 1 || $model->is_for_mating == 1) {
                    $model->is_ad_active = 1;
                }

                if ($model->save()) {
                    $photos->imageFiles = UploadedFile::getInstances($photos, 'imageFiles');
                    $photos->cat_id = $model->id;
                    $documents->documentFiles = UploadedFile::getInstances($documents, 'documentFiles');
                    $documents->cat_id = $model->id;

                    if ($photos->uploadMultiple()) {
                        Yii::$app->session->setFlash('success', 'Фотографии успешно загружены');
                    }
                    if ($documents->uploadMultiple()) {
                        Yii::$app->session->setFlash('success', 'Документы успешно загружены');
                    }

                    Yii::$app->session->setFlash('success', 'Изменения сохранены и отправлены на модерацию.');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
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
        $cat_id = Yii::$app->request->post('cat_id');

        $photo = CatPhotos::findOne(['id' => $id, 'cat_id' => $cat_id]);
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

        $order = Yii::$app->request->post('sortData');

        if (!is_array($order)) {
            return ['success' => false, 'message' => 'Данные не получены'];
        }

        foreach ($order as $key => $sortOrder) {
            $photo = \app\models\CatPhotos::findOne($key);
            if ($photo !== null) {
                $photo->sort_order = $sortOrder;
                $photo->save(false);
            }
        }

        return ['success' => true];
    }

    /**
     * Удаление животных доступно ТОЛЬКО администратору — см. controllers/admin/CatController.
     * Здесь этого действия намеренно нет (раньше было открыто без проверки прав — критическая дыра).
     */

    /**
     * Finds the Cat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cat::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}