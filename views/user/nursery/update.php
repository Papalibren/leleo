<?php
// views/user/nursery/update.php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Nursery $model */

$this->title = 'Редактировать питомник: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Питомники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="nursery-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>