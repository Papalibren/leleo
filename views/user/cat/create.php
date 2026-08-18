<?php

use yii\helpers\Html;
$this -> params['action'] = 'create';

/** @var yii\web\View $this */
/** @var app\models\Cat $model */

$this->title = 'Добавить бенгальскую кошку';
$this->params['breadcrumbs'][] = ['label' => 'Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cat-create">

    <h1 class="text-center fs-3"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'photos' => $photos,
        'documents' => $documents,
    ]) ?>

</div>
