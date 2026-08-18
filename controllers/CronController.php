<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use yii\helpers\Console;
use app\models\Cat;

class CronController extends Controller
{


    public function actionUsers()
    {
        $now = date('Y-m-d H:i:s');
        $count = 0;

        $users = User::find()
            ->where(['is_advanced' => 1])
            ->andWhere(['<=', 'advanced_until', $now])
            ->all();

        foreach ($users as $user) {
            $user->is_advanced = 0;
            $user->advanced_until = null;
            $user->save(false);

            $cats = Cat::find()
                ->where(['or', ['owner_id' => $user->id], ['breeder_id' => $user->id]])
                ->all();

            foreach ($cats as $cat) {
                $cat->is_for_sale = 0;
                $cat->is_for_mating = 0;
                $cat->save(false);
            }

        }
        return 0;
    }
}
