<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Cat;
use app\models\Dog;

class AnnouncementController extends Controller
{
    public function actionIndex($animal_type = 'cats', $type = 'sale')
    {
        if ($animal_type === 'cats') {
            $query = Cat::find()->where(['is_active' => 1, 'is_ad_active' => 1]);
            $modelName = 'Кошки';
        } else {
            $query = Dog::find()->where(['is_active' => 1, 'is_ad_active' => 1]);
            $modelName = 'Собаки';
        }

        if ($type === 'sale') {
            $query->andWhere(['is_for_sale' => 1]);
        } elseif ($type === 'mating') {
            $query->andWhere(['is_for_mating' => 1]);
        }

        $animals = $query->all();

        return $this->render('index', [
            'animal_type' => $animal_type,
            'type' => $type,
            'animals' => $animals,
            'modelName' => $modelName,
        ]);
    }
}