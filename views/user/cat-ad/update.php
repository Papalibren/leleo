<?php
// views/user/cat-ad/update.php

use yii\helpers\Html;

$this->title = 'Редактировать объявление: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Мои объявления по кошкам', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<div class="cat-ad-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>
</div>