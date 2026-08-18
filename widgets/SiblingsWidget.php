<?php
namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Cat;

class SiblingsWidget extends Widget
{
    /** @var Cat */
    public $model;

    public function run()
    {
        $query = Cat::find();

        if(!$this -> model-> father_id && !$this -> model -> mother_id){
            return Html::tag('div', 'Сибсы не найдены.', ['class' => 'alert alert-info']);
        }

        if ($this->model->father_id) {
            $query->where(['father_id' => $this->model->father_id]);
        }

        if ($this->model->mother_id) {
            $query->orWhere(['mother_id' => $this->model->mother_id]);
        }

        $query -> andWhere(['!=', 'id', $this->model->id]);

        $siblings = $query->with('catPhotos')->all();

        if (empty($siblings)) {
            return Html::tag('div', 'Сибсы не найдены.', ['class' => 'alert alert-info']);
        }

        return $this->render('siblings', [
            'siblings' => $siblings,
        ]);
    }
}
