<?php

namespace app\controllers\admin;

use Yii;
use app\models\Cat;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\admin\CatSearch;

/**
 * CatController implements the CRUD actions for Cat model.
 */
class CatController extends Controller
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
     * Lists all Cat models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
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
        $model = $this->findModel($id);



        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Cat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Cat();

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
     * Updates an existing Cat model.
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

    public function actionHistory($id)
    {
        $cat = $this->findModel($id);
        $history = $cat->getHistory()->with(['user', 'moderatedBy'])->all();

        return $this->render('history', [
            'cat' => $cat,
            'history' => $history,
        ]);
    }

    /**
     * Deletes an existing Cat model.
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
        if (!$tree || !isset($tree['cat'])) {
            return $list;
        }

        $cat = $tree['cat'];
        $id = $cat->id;

        $pids = [];



        // Предотвращаем повторное добавление
        if (in_array($id, $processed)) {
            return $list;
        }
        $processed[] = $id;

        $node = [
            'id' => $id,
            'name' => $cat->name,
            'gender' => $cat->gender === 'м' ? 'male' : 'female',
            'img' => $cat->mainPhotoPath ? Yii::getAlias('@web') . '/' . $cat->mainPhotoPath : null,
        ];

        // Устанавливаем родителей, если есть
        if (!empty($tree['father']['cat'])) {
            $node['fid'] = $tree['father']['cat']->id;
        }
        if (!empty($tree['mother']['cat'])) {
            $node['mid'] = $tree['mother']['cat']->id;
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
