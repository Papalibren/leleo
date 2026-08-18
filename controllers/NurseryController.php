<?php

namespace app\controllers;

use yii\data\ActiveDataProvider;
use app\models\Nursery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Cat;
use app\models\Dog;



class NurseryController extends Controller
{

    // controllers/NurseryController.php
    public function actionList($animal_type = null)
    {
        $query = Nursery::find();

        // Если указан фильтр по типу животных, находим питомники с соответствующими животными
        if ($animal_type) {
            $subQuery = null;

            if ($animal_type === 'cats') {
                // Питомники, у которых есть кошки (либо производители, либо рожденные)
                $subQueryCatProducers = Cat::find()
                    ->select('breeder_id')
                    ->where(['is_active' => 1])
                    ->andWhere(['is not', 'breeder_id', null]);

                $subQueryCatBorn = Cat::find()
                    ->select('owner_id')
                    ->where(['is_active' => 1])
                    ->andWhere(['is not', 'owner_id', null]);

                $query->andWhere([
                    'or',
                    ['in', 'breeder_id', $subQueryCatProducers],
                    ['in', 'breeder_id', $subQueryCatBorn]
                ]);
            } elseif ($animal_type === 'dogs') {
                // Питомники, у которых есть собаки (либо производители, либо рожденные)
                $subQueryDogProducers = Dog::find()
                    ->select('breeder_id')
                    ->where(['is_active' => 1])
                    ->andWhere(['is not', 'breeder_id', null]);

                $subQueryDogBorn = Dog::find()
                    ->select('owner_id')
                    ->where(['is_active' => 1])
                    ->andWhere(['is not', 'owner_id', null]);

                $query->andWhere([
                    'or',
                    ['in', 'breeder_id', $subQueryDogProducers],
                    ['in', 'breeder_id', $subQueryDogBorn]
                ]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
            'sort' => [
                'defaultOrder' => [
                    'title' => SORT_ASC,
                ]
            ]
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'animal_type' => $animal_type,
        ]);
    }

    // controllers/NurseryController.php
    public function actionView($id, $animal_type = 'cats', $dog_breed = null)
    {
        $model = $this->findModel($id);

        // Определяем типы животных для фильтрации
        $animalTypes = [
            'cats' => 'Кошки',
            'dogs' => 'Собаки',
            'all' => 'Все'
        ];

        // Породы собак для фильтра
        $dogBreeds = [
            null => 'Все породы',
            'Шпиц' => 'Шпиц',
            'Тибетский мастиф' => 'Тибетский мастиф'
        ];

        // Уникальные производители (без дублирования)
        $producers = [];

        // Кошки-производители (где владелец - питомник)
        $producersCats = Cat::find()
            ->where(['owner_id' => $model->breeder_id, 'is_active' => 1])
            ->all();

        // Собаки-производители (где владелец - питомник)
        $producersDogs = Dog::find()
            ->where(['owner_id' => $model->breeder_id, 'is_active' => 1])
            ->all();

        // Добавляем в общий массив
        foreach ($producersCats as $cat) {
            $producers[$cat->id . '-cat'] = $cat;
        }
        foreach ($producersDogs as $dog) {
            $producers[$dog->id . '-dog'] = $dog;
        }

        // Родившиеся в питомнике (только где заводчик - питомник)
        $bornPets = [];

        // Кошки, рожденные в питомнике
        $bornCats = Cat::find()
            ->where(['breeder_id' => $model->breeder_id, 'is_active' => 1])
            ->all();

        // Собаки, рожденные в питомнике
        $bornDogs = Dog::find()
            ->where(['breeder_id' => $model->breeder_id, 'is_active' => 1])
            ->all();

        // Добавляем в общий массив
        foreach ($bornCats as $cat) {
            $bornPets[$cat->id . '-cat'] = $cat;
        }
        foreach ($bornDogs as $dog) {
            $bornPets[$dog->id . '-dog'] = $dog;
        }

        // Фильтрация по типу животного
        $filteredProducers = array_filter($producers, function ($animal) use ($animal_type, $dog_breed) {
            // Фильтр по типу животного
            if ($animal_type === 'cats' && !($animal instanceof \app\models\Cat)) return false;
            if ($animal_type === 'dogs' && !($animal instanceof \app\models\Dog)) return false;

            // Дополнительный фильтр по породе для собак
            if ($animal_type === 'dogs' && $dog_breed && $animal instanceof \app\models\Dog) {
                return $animal->breed === $dog_breed;
            }

            return true;
        });

        $filteredBornPets = array_filter($bornPets, function ($pet) use ($animal_type, $dog_breed) {
            // Фильтр по типу животного
            if ($animal_type === 'cats' && !($pet instanceof \app\models\Cat)) return false;
            if ($animal_type === 'dogs' && !($pet instanceof \app\models\Dog)) return false;

            // Дополнительный фильтр по породе для собак
            if ($animal_type === 'dogs' && $dog_breed && $pet instanceof \app\models\Dog) {
                return $pet->breed === $dog_breed;
            }

            return true;
        });

        return $this->render('view', [
            'model' => $model,
            'producers' => $filteredProducers,
            'bornPets' => $filteredBornPets,
            'animal_type' => $animal_type,
            'animalTypes' => $animalTypes,
            'dog_breed' => $dog_breed,
            'dogBreeds' => $dogBreeds,
        ]);
    }



    protected function findModel($id)
    {
        if (($model = Nursery::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
