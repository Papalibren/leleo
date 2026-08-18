<?php

namespace app\controllers\admin;
use Yii;
use app\models\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Auth;
use yii\filters\AccessControl;

class HomeController extends Controller
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


    public function actionIndex()
    {

        return $this->render('index');
    }


}





