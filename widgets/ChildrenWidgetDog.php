<?php
namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Dog;

class ChildrenWidgetDog extends Widget
{
    /** @var Dog */
    public $model;

    public function run()
    {
        $query = Dog::find()
            ->where(['father_id' => $this->model->id])
            ->orWhere(['mother_id' => $this->model->id]);

        $children = $query->with('dogPhotos')->all();

        if (empty($children)) {
            return Html::tag('div', 'Потомков не найдено.', ['class' => 'alert alert-info']);
        }

        return $this->render('children-dog', [
            'children' => $children,
        ]);
    }
}
