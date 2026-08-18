<?php
// models/search/AdsSearch.php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use app\models\Cat;
use app\models\Dog;

class AdsSearch extends Model
{
    public $type;
    public $search;
    public $ad_type;
    public $status;

    public function rules()
    {
        return [
            [['type', 'search', 'ad_type', 'status'], 'safe'],
        ];
    }

    public function search($params)
    {
        $this->load($params);

        // Создаем запросы для кошек и собак
        $catQuery = Cat::find()
            ->where(['or',
                ['is_for_sale' => 1],
                ['is_for_mating' => 1]
            ])
            ->andWhere(['is_active' => 1]);

        $dogQuery = Dog::find()
            ->where(['or',
                ['is_for_sale' => 1],
                ['is_for_mating' => 1]
            ])
            ->andWhere(['is_active' => 1]);

        // Применяем фильтры поиска
        if (!empty($this->search)) {
            $catQuery->andWhere(['or',
                ['like', 'name', $this->search],
                ['like', 'pedigree_number', $this->search],
                ['like', 'chip', $this->search]
            ]);

            $dogQuery->andWhere(['or',
                ['like', 'name', $this->search],
                ['like', 'pedigree_number', $this->search],
                ['like', 'chip', $this->search]
            ]);
        }

        // Фильтр по типу объявления
        if ($this->ad_type === 'sale') {
            $catQuery->andWhere(['is_for_sale' => 1]);
            $dogQuery->andWhere(['is_for_sale' => 1]);
        } elseif ($this->ad_type === 'mating') {
            $catQuery->andWhere(['is_for_mating' => 1]);
            $dogQuery->andWhere(['is_for_mating' => 1]);
        }

        // Фильтр по статусу
        if ($this->status === 'active') {
            $catQuery->andWhere(['is_ad_active' => 1]);
            $dogQuery->andWhere(['is_ad_active' => 1]);
        } elseif ($this->status === 'inactive') {
            $catQuery->andWhere(['is_ad_active' => 0]);
            $dogQuery->andWhere(['is_ad_active' => 0]);
        }

        // Получаем результаты
        $cats = $catQuery->all();
        $dogs = $dogQuery->all();

        // Объединяем результаты
        $allAds = [];
        foreach ($cats as $cat) {
            $allAds[] = [
                'type' => 'cat',
                'model' => $cat,
                'id' => $cat->id,
                'name' => $cat->name,
                'animal_type' => 'Кошка',
                'breed' => $cat->breed,
                'is_for_sale' => $cat->is_for_sale,
                'is_for_mating' => $cat->is_for_mating,
                'is_ad_active' => $cat->is_ad_active,
                'price' => $cat->price,
                'created_at' => $cat->created_at,
            ];
        }

        foreach ($dogs as $dog) {
            $allAds[] = [
                'type' => 'dog',
                'model' => $dog,
                'id' => $dog->id,
                'name' => $dog->name,
                'animal_type' => 'Собака',
                'breed' => $dog->breed,
                'is_for_sale' => $dog->is_for_sale,
                'is_for_mating' => $dog->is_for_mating,
                'is_ad_active' => $dog->is_ad_active,
                'price' => $dog->price,
                'created_at' => $dog->created_at,
            ];
        }

        // Создаем провайдер данных для массива
        return new ArrayDataProvider([
            'allModels' => $allAds,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['name', 'animal_type', 'breed', 'price', 'created_at'],
                'defaultOrder' => ['created_at' => SORT_DESC],
            ],
        ]);
    }

    public function attributeLabels()
    {
        return [
            'type' => 'Тип животного',
            'search' => 'Поиск',
            'ad_type' => 'Тип объявления',
            'status' => 'Статус',
        ];
    }
}