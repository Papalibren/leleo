<?php

namespace app\models\admin;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cat;

class CatSearch extends Cat
{
    public function rules()
    {
        return [
            [['id', 'is_active', 'is_for_mating', 'is_for_sale'], 'integer'],
            [['name', 'breed', 'gender', 'birth_date', 'created_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios(); // обход переопределения
    }

    public function search($params)
    {
        $query = Cat::find()->with('breeder');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 5],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Если валидация не проходит — не возвращаем ничего
            $query->where('0=1');
            return $dataProvider;
        }

        // Фильтрация
        $query->andFilterWhere([
            'id' => $this->id,
            'is_active' => $this->is_active,
            'is_for_mating' => $this->is_for_mating,
            'is_for_sale' => $this->is_for_sale,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'breed', $this->breed])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'birth_date', $this->birth_date]);

        return $dataProvider;
    }
}
