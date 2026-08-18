<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */

$cats = $dataProvider->models;

$alphabet_ru = ['А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Э', 'Ю', 'Я'];
$alphabet_en = range('A', 'Z');

function renderLetterMenu($letters, $activeLetter)
{
    foreach ($letters as $char) {
        $url = Url::to(['/cats/index', 'letter' => $char]);
        $style = ($activeLetter === $char) ? 'font-weight: bold; text-decoration: underline;' : '';
        echo Html::a($char, $url, ['style' => $style, 'class' => 'me-2 text-secondary']);
    }
}

$this->title = "Бенгальские кошки";
?>
<div class="container mt-4">
    <h2 class="catalog-header">Каталог → <span class="text-warning">
            <a class="text-warning" href="/cats"><?= $this->title ?></a>
        </span></h2>

    <div class="mt-3 text-center">
        <div class="mb-2">
            <?php renderLetterMenu($alphabet_ru, $letter ?? null); ?>
        </div>
        <div>
            <?php renderLetterMenu($alphabet_en, $letter ?? null); ?>
        </div>
    </div>

    <div class="mt-4">
        <?= Html::beginForm(['/cats/index'], 'get', ['class' => 'd-flex mb-3']) ?>
        <?= Html::input('text', 'search', $search ?? '', [
            'class' => 'form-control me-2',
            'placeholder' => 'Поиск по имени кошки...',
        ]) ?>
        <?php if (!empty($letter)): ?>
            <?= Html::hiddenInput('letter', $letter) ?>
        <?php endif; ?>
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
        <?= Html::endForm() ?>
    </div>

    <h3 class="new-title mt-4">
        <?= $letter ? "Кошки, имя которых начинается на &laquo;<span class='text-warning'>{$letter}</span>&raquo;" : "Самые новые" ?>
    </h3>

    <?php if (empty($cats)): ?>
        <div class="alert alert-warning text-center">
            Кошек, имя которых начинается на &laquo;<?= Html::encode($letter) ?>&raquo;, не найдено.
        </div>
    <?php endif; ?>

    <?php foreach ($cats as $cat): ?>
        <div class="catalog-item d-flex align-items-center border-bottom border-3 mb-4 p-2">
            <div style="width:150px;">
                <?= Html::a(
                    Html::img('/' . $cat->getFirstPhoto()->image_path, [
                        'class' => 'img-fluid',
                        'alt' => $cat->name,
                    ]),
                    ['cats/view', 'id' => $cat->id, 'translit' => $cat->translit]
                ) ?>
            </div>
            <div class="ms-3">
                <h5>
                    <?= Html::a(Html::encode($cat->name), ['cats/view', 'id' => $cat->id, 'translit' => $cat->translit]) ?>
                    <span><?= $cat->gender == 'кошка' ? '♀️' : '♂️' ?></span>
                </h5>
                <strong><?= Html::encode($cat->breed) ?></strong><br>
                № родословной: <?= Html::encode($cat->pedigree_number) ?><br>
                Дата рождения: <?= Yii::$app->formatter->asDate($cat->birth_date, 'php:d.m.Y') ?><br>
                Добавлен<?= $cat->gender == 'кошка' ? 'а' : '' ?> в каталог:
                <?= Yii::$app->formatter->asDate($cat->created_at, 'php:d.m.Y') ?>

                <?php
                $announcementLinks = [];
                if ($cat->is_for_sale && $cat->is_ad_active) {
                    $announcementLinks[] = Html::a(
                        '<span class="badge bg-success me-1">В продаже</span>',
                        Url::to(['/announcement/index', 'type' => 'sale', 'cat_id' => $cat->id])
                    );
                }
                if ($cat->is_for_mating && $cat->is_ad_active) {
                    $announcementLinks[] = Html::a(
                        '<span class="badge bg-primary me-1">Для вязки</span>',
                        Url::to(['/announcement/index', 'type' => 'mating', 'cat_id' => $cat->id])
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
                <?php if ($cat->breeder): ?>
                    <?= Html::encode($cat->breeder->first_name) ?>
                    <?= Html::encode($cat->breeder->last_name) ?>
                <?php else: ?>
                    Не указан
                <?php endif; ?>
                <br>

                <strong>Питомник:</strong>
                <?php if ($cat->breeder && $cat->breeder->nursery): ?>
                    <?= Html::a(
                        Html::encode($cat->breeder->nursery->title),
                        ['/nursery/view', 'id' => $cat->breeder->nursery->id],
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
