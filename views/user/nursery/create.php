<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Nursey $model */

$this->title = 'Create Nursey';
$this->params['breadcrumbs'][] = ['label' => 'Nurseys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nursey-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
