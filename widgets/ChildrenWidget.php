<?php
namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Cat;

class ChildrenWidget extends Widget
{
    /** @var Cat */
    public $model;

    public function run()
    {
        $query = Cat::find()
            ->where(['father_id' => $this->model->id])
            ->orWhere(['mother_id' => $this->model->id]);

        $children = $query->with('catPhotos')->all();

        if (empty($children)) {
            return Html::tag('div', 'Потомков не найдено.', ['class' => 'alert alert-info']);
        }

        return $this->render('children', [
            'children' => $children,
        ]);
    }
}
