<?php
// views/user/dog-ad/update.php

use yii\helpers\Html;

$this->title = 'Редактировать объявление: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Мои объявления по собакам', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<div class="dog-ad-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>
</div>