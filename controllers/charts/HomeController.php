<?php

namespace app\controllers\charts;

use app\models\Announcements;
use app\models\Auth;
use app\models\Customer;
use app\models\Feedback;
use app\models\Order;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Users;



class HomeController extends Controller
{

    public function actionIndex()
    {

        return $this->render('index');
    }
}
