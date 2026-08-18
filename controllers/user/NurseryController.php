<?php

namespace app\controllers\user;

use app\models\Nursery;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\UploadedFile;
use app\models\Cat;
use app\models\Dog;

/**
 * NurseyController implements the CRUD actions for Nursey model.
 */
class NurseryController extends Controller
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
            ]
        );
    }

    /**
     * Lists all Nursey models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Nursery::find()->where(['breeder_id' => Yii::$app->user->id]),
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
     * Displays a single Nursey model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    // controllers/user/NurseryController.php
    public function actionView($id)
    {
        $model = $this->findModel($id);

        // Инициализируем переменные
        $producers = [];
        $bornPets = [];

        // Получаем производителей (животные, где владелец - питомник)
        $producersCats = Cat::find()->where(['owner_id' => $model->breeder_id, 'is_active' => 1])->all();
        $producersDogs = Dog::find()->where(['owner_id' => $model->breeder_id, 'is_active' => 1])->all();

        foreach ($producersCats as $cat) {
            $producers[$cat->id . '-cat'] = $cat;
        }
        foreach ($producersDogs as $dog) {
            $producers[$dog->id . '-dog'] = $dog;
        }

        // Получаем рожденных в питомнике (животные, где заводчик - питомник)
        $bornCats = Cat::find()->where(['breeder_id' => $model->breeder_id, 'is_active' => 1])->all();
        $bornDogs = Dog::find()->where(['breeder_id' => $model->breeder_id, 'is_active' => 1])->all();

        foreach ($bornCats as $cat) {
            $bornPets[$cat->id . '-cat'] = $cat;
        }
        foreach ($bornDogs as $dog) {
            $bornPets[$dog->id . '-dog'] = $dog;
        }

        return $this->render('view', [
            'model' => $model,
            'producers' => $producers,
            'bornPets' => $bornPets,
        ]);
    }

    /**
     * Creates a new Nursey model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Nursery();


        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->validate() && $model->uploadPhoto() && $model->save(false)) {
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
     * Updates an existing Nursey model.
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
     * Deletes an existing Nursey model.
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
     * Finds the Nursey model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Nursey the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nursery::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
