<?php
// models/admin/CatModerationSearch.php

namespace app\models\admin;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CatModeration;

class CatModerationSearch extends CatModeration
{
    public function rules()
    {
        return [
            [['id', 'cat_id', 'user_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CatModeration::find()->with(['cat', 'user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'cat_id' => $this->cat_id,
            'user_id' => $this->user_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['>=', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}