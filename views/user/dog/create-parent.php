<?php
// views/user/dog/create-parent.php

use yii\helpers\Html;

$this->title = 'Добавить родителя';
$this->params['breadcrumbs'][] = ['label' => 'Собаки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['action'] = 'create';
?>
<div class="dog-create">

    <h1 class="text-center fs-3"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-parent', [
        'model' => $model,
        'photos' => $photos,
        'type' => $type,
        'child_id' => $child_id
    ]) ?>

</div>