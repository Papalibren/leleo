<?php

namespace app\controllers\admin;

use Yii;
use app\models\Dog;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\admin\DogSearch;

/**
 * DogController implements the CRUD actions for Dog model.
 */
class DogController extends Controller
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
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'create', 'update', 'view'],
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'create', 'update', 'view'],
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return Yii::$app->user->identity && Yii::$app->user->identity->is_admin == 1;
                            },
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Dog models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single Dog model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);



        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Dog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Dog();

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
     * Updates an existing Dog model.
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
     * Deletes an existing Dog model.
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
     * Finds the Dog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Dog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dog::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionToggleStatus($id)
    {
        $model = $this->findModel($id);

        // Переключение is_active
        $model->toggleStatusWithAncestors();

        Yii::$app->session->setFlash('success', 'Статус успешно изменён.');

        return $this->redirect(['view', 'id' => $model->id]);
    }

protected function flattenTreeForJs($tree, &$list = [], &$processed = [])
{
    if (!$tree || !isset($tree['Dog'])) {
        return $list;
    }

    $Dog = $tree['Dog'];
    $id = $Dog->id;

    $pids = [];



    // Предотвращаем повторное добавление
    if (in_array($id, $processed)) {
        return $list;
    }
    $processed[] = $id;

    $node = [
        'id' => $id,
        'name' => $Dog->name,
        'gender' => $Dog->gender === 'м' ? 'male' : 'female',
        'img' => $Dog->mainPhotoPath ? Yii::getAlias('@web') . '/' . $Dog->mainPhotoPath : null,
    ];

    // Устанавливаем родителей, если есть
    if (!empty($tree['father']['Dog'])) {
        $node['fid'] = $tree['father']['Dog']->id;
    }
    if (!empty($tree['mother']['Dog'])) {
        $node['mid'] = $tree['mother']['Dog']->id;
    }

    // Добавляем текущую кошку в список
    $list[] = $node;

    // Добавляем отца и мать рекурсивно
    if (!empty($tree['father'])) {
        $this->flattenTreeForJs($tree['father'], $list, $processed);
    }
    if (!empty($tree['mother'])) {
        $this->flattenTreeForJs($tree['mother'], $list, $processed);
    }

    return $list;
}

}
