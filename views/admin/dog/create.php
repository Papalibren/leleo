<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Cat $model */

$this->title = 'Create Cat';
$this->params['breadcrumbs'][] = ['label' => 'Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
