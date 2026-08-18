<?php

namespace app\models\admin;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

class UserSearch extends User
{
    public function rules()
    {
        return [
            [['id', 'is_active', 'is_advanced'], 'integer'],
            [['email', 'first_name', 'last_name', 'country', 'city'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios(); // обход переопределения сценариев User
    }

    public function search($params)
    {
        $query = User::find()->where(['is_admin' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC], // новые пользователи сверху
                'attributes' => ['id', 'email', 'first_name', 'last_name', 'country', 'city', 'created_at'],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_active' => $this->is_active,
            'is_advanced' => $this->is_advanced,
        ]);

        $query
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'city', $this->city]);

        return $dataProvider;
    }
}