<?php
// views/dogs/index.php

use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */

$dogs = $dataProvider->models;

$alphabet_ru = ['А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Э', 'Ю', 'Я'];
$alphabet_en = range('A', 'Z');

function renderLetterMenu($letters, $activeLetter)
{
    foreach ($letters as $char) {
        $url = Url::to(['/dogs/index', 'letter' => $char]);
        $style = ($activeLetter === $char) ? 'font-weight: bold; text-decoration: underline;' : '';
        echo Html::a($char, $url, ['style' => $style, 'class' => 'me-2 text-secondary']);
    }
}

$this->title = "Собаки";
?>
<div class="container mt-4">
    <h2 class="catalog-header">Каталог → <span class="text-warning">
            <a class="text-warning" href="/dogs"><?= $this->title ?></a>
        </span></h2>

    <!-- Фильтр по породе -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="btn-group">
                <?= Html::a('Все породы', ['index'], ['class' => 'btn btn-outline-primary' . (!$breed ? ' active' : '')]) ?>
                <?= Html::a('Шпиц', ['index', 'breed' => 'Шпиц'], ['class' => 'btn btn-outline-primary' . ($breed == 'Шпиц' ? ' active' : '')]) ?>
                <?= Html::a('Тибетский мастиф', ['index', 'breed' => 'Тибетский мастиф'], ['class' => 'btn btn-outline-primary' . ($breed == 'Тибетский мастиф' ? ' active' : '')]) ?>
            </div>
        </div>
    </div>

    <div class="mt-3 text-center">
        <div class="mb-2">
            <?php renderLetterMenu($alphabet_ru, $letter ?? null); ?>
        </div>
        <div>
            <?php renderLetterMenu($alphabet_en, $letter ?? null); ?>
        </div>
    </div>

    <div class="mt-4">
        <?= Html::beginForm(['/dogs/index'], 'get', ['class' => 'd-flex mb-3']) ?>
        <?= Html::input('text', 'search', $search ?? '', [
            'class' => 'form-control me-2',
            'placeholder' => 'Поиск по кличке собаки...',
        ]) ?>
        <?php if (!empty($breed)): ?>
            <?= Html::hiddenInput('breed', $breed) ?>
        <?php endif; ?>
        <?php if (!empty($letter)): ?>
            <?= Html::hiddenInput('letter', $letter) ?>
        <?php endif; ?>
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
        <?= Html::endForm() ?>
    </div>

    <h3 class="new-title mt-4">
        <?php if ($breed): ?>
            <?= $letter ? "Собаки породы {$breed}, имя которых начинается на &laquo;<span class='text-warning'>{$letter}</span>&raquo;" : "Собаки породы {$breed}" ?>
        <?php else: ?>
            <?= $letter ? "Собаки, имя которых начинается на &laquo;<span class='text-warning'>{$letter}</span>&raquo;" : "Самые новые" ?>
        <?php endif; ?>
    </h3>

    <?php if (empty($dogs)): ?>
        <div class="alert alert-warning text-center">
            Собак<?= $breed ? " породы {$breed}" : '' ?><?= $letter ? ", имя которых начинается на &laquo;" . Html::encode($letter) . "&raquo;" : '' ?>, не найдено.
        </div>
    <?php endif; ?>

    <?php foreach ($dogs as $dog): ?>
        <div class="catalog-item d-flex align-items-center border-bottom border-3 mb-4 p-2">
            <div style="width:150px;">
                <?= Html::a(
                    $dog->getFirstPhoto() ?
                    Html::img('/' . $dog->getFirstPhoto()->image_path, [
                        'class' => 'img-fluid',
                        'alt' => $dog->name,
                    ]) :
                    Html::img('/img/default-dog.webp', [
                        'class' => 'img-fluid',
                        'alt' => 'Нет фото',
                        'style' => 'width: 150px; height: 150px; object-fit: cover;'
                    ]),
                    ['dogs/view', 'id' => $dog->id, 'translit' => $dog->translit]
                ) ?>
            </div>
            <div class="ms-3">
                <h5>
                    <?= Html::a(Html::encode($dog->name), ['dogs/view', 'id' => $dog->id, 'translit' => $dog->translit]) ?>
                    <span><?= $dog->gender == 'сука' ? '♀️' : '♂️' ?></span>
                </h5>
                <strong><?= Html::encode($dog->breed) ?></strong><br>
                № родословной: <?= Html::encode($dog->pedigree_number) ?><br>
                Дата рождения: <?= Yii::$app->formatter->asDate($dog->birth_date, 'php:d.m.Y') ?><br>
                Добавлен<?= $dog->gender == 'сука' ? 'а' : '' ?> в каталог:
                <?= Yii::$app->formatter->asDate($dog->created_at, 'php:d.m.Y') ?>

                <?php
                $announcementLinks = [];
                if ($dog->is_for_sale && $dog->is_ad_active) {
                    $announcementLinks[] = Html::a(
                        '<span class="badge bg-success me-1">В продаже</span>',
                        Url::to(['/announcement/index', 'type' => 'sale', 'dog_id' => $dog->id])
                    );
                }
                if ($dog->is_for_mating && $dog->is_ad_active) {
                    $announcementLinks[] = Html::a(
                        '<span class="badge bg-primary me-1">Для вязки</span>',
                        Url::to(['/announcement/index', 'type' => 'mating', 'dog_id' => $dog->id])
                    );
                }
                ?>

                <?php if (!empty($announcementLinks)): ?>
                    <div class="mt-2">
                        <?= implode(' ', $announcementLinks) ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="ms-auto text-end">
                <strong>Заводчик:</strong>
                <?php if ($dog->breeder): ?>
                    <?= Html::encode($dog->breeder->first_name) ?>
                    <?= Html::encode($dog->breeder->last_name) ?>
                <?php else: ?>
                    Не указан
                <?php endif; ?>
                <br>

                <strong>Питомник:</strong>
                <?php if ($dog->breeder && $dog->breeder->nursery): ?>
                    <?= Html::a(
                        Html::encode($dog->breeder->nursery->title),
                        ['/nursery/view', 'id' => $dog->breeder->nursery->id],
                        ['target' => '_blank']
                    ) ?>
                <?php else: ?>
                    не указан
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Пагинация -->
    <div class="mt-4">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination justify-content-center'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['class' => 'page-link'],
            'prevPageLabel' => '‹',
            'nextPageLabel' => '›',
        ]) ?>
    </div>
</div>