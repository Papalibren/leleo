<?php
// views/nursery/list.php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;

$this->title = 'Питомники';
$this->params['breadcrumbs'][] = $this->title;

// Определяем заголовок в зависимости от фильтра
$pageTitle = 'Питомники';
if ($animal_type === 'cats') {
    $pageTitle = 'Питомники с кошками';
} elseif ($animal_type === 'dogs') {
    $pageTitle = 'Питомники с собаками';
}
?>

<div class="container py-5">
    <h1 class="mb-4"><?= Html::encode($pageTitle) ?></h1>

    <!-- Фильтр по типу животных -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="btn-group">
                        <?= Html::a('Все питомники', ['list'], [
                            'class' => 'btn btn-outline-primary' . (!$animal_type ? ' active' : '')
                        ]) ?>
                        <?= Html::a('С кошками', ['list', 'animal_type' => 'cats'], [
                            'class' => 'btn btn-outline-primary' . ($animal_type === 'cats' ? ' active' : '')
                        ]) ?>
                        <?= Html::a('С собаками', ['list', 'animal_type' => 'dogs'], [
                            'class' => 'btn btn-outline-primary' . ($animal_type === 'dogs' ? ' active' : '')
                        ]) ?>
                    </div>

                    <?php if ($animal_type): ?>
                        <div class="mt-2">
                            <small class="text-muted">
                                Фильтр:
                                <?= $animal_type === 'cats' ? 'Показываются питомники с зарегистрированными кошками' : '' ?>
                                <?= $animal_type === 'dogs' ? 'Показываются питомники с зарегистрированными собаками' : '' ?>
                            </small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'layout' => "{items}\n{pager}",
        'options' => ['class' => 'row'],
        'itemOptions' => ['class' => 'col-md-4 mb-4'],
        'emptyText' => 'Питомники не найдены.',
        'emptyTextOptions' => ['class' => 'alert alert-info col-12'],
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'maxButtonCount' => 5,
        ],
    ]) ?>
</div>