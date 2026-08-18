<?php
// views/announcement/index.php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="container mt-4">
    <!-- Переключатель между кошками и собаками -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="btn-group">
                <?= Html::a('Кошки', ['index', 'animal_type' => 'cats', 'type' => $type], [
                    'class' => 'btn btn-outline-primary' . ($animal_type === 'cats' ? ' active' : '')
                ]) ?>
                <?= Html::a('Собаки', ['index', 'animal_type' => 'dogs', 'type' => $type], [
                    'class' => 'btn btn-outline-primary' . ($animal_type === 'dogs' ? ' active' : '')
                ]) ?>
            </div>
        </div>
    </div>

    <h2 class="header-title">
        <?php if ($type === 'sale'): ?>
            <?= $modelName ?> для продажи
        <?php else: ?>
            <?= $modelName ?> для вязки
        <?php endif; ?>
    </h2>

    <div class="alert alert-info">
        Хотите подать объявление?
        Заполните <?= Html::a(
            'форму добавления ' . ($animal_type === 'cats' ? 'кошки' : 'собаки'), 
            [$animal_type === 'cats' ? '/user/cat/create' : '/user/dog/create'], 
            ['class' => 'text-danger']
        ) ?> и отметьте галочкой
        "<?= $type === 'sale' ? 'Для продажи' : 'Для вязки' ?>".
    </div>

    <!-- Фильтры -->
    <div class="row mb-3">
        <div class="col-md-3">
            <label class="form-label">Пол:</label>
            <select class="form-select">
                <option><?= $animal_type === 'cats' ? 'Коты' : 'Кобели' ?></option>
                <option><?= $animal_type === 'cats' ? 'Кошки' : 'Суки' ?></option>
                <option>Все</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Порода:</label>
            <select class="form-select">
                <option>Все породы</option>
                <?php if ($animal_type === 'dogs'): ?>
                    <option>Шпиц</option>
                    <option>Тибетский мастиф</option>
                <?php else: ?>
                    <option>Бенгальская</option>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Окрас:</label>
            <select class="form-select">
                <option>Любой</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Сортировка:</label>
            <select class="form-select">
                <option>Новые</option>
                <option>Дешевле</option>
                <option>Дороже</option>
            </select>
        </div>
    </div>
    <button class="btn btn-success">Найти</button>

    <h5 class="mt-4">Результатов: <?= count($animals) ?></h5>

    <?php foreach ($animals as $animal): ?>
        <div class="card-add mt-3 d-flex align-items-start">
            <?= Html::img($animal->mainPhotoPath, [
                'class' => 'img-thumbnail me-3',
                'width' => 170,
                'alt' => $animal->name
            ]) ?>
            <div>
                <h5>
                    <?= Html::a(
                        Html::encode($animal->name), 
                        [$animal_type . '/view', 'id' => $animal->id, 'translit' => $animal->translit]
                    ) ?>
                </h5>
                <p>
                    <strong><?= Html::encode($animal->breed ?: 'Порода не указана') ?></strong><br>
                    Возраст:
                    <?= $animal->birth_date
                        ? str_replace(' назад', '', Yii::$app->formatter->asRelativeTime(strtotime($animal->birth_date)))
                        : 'Не указан' ?><br>
                    Родил<?= $animal_type === 'cats' ? 'ась' : 'ся' ?>:
                    <?= $animal->birth_date
                        ? Yii::$app->formatter->asDate($animal->birth_date)
                        : 'Не указана' ?><br>
                    Объявление подано:
                    <?= Yii::$app->formatter->asRelativeTime(strtotime($animal->created_at)) ?><br>
                </p>
                <?php if ($type === 'sale'): ?>
                    <span class="price-tag"><?= $animal->price ? $animal->price . ' ₽' : 'Цена не указана' ?></span>
                <?php else: ?>
                    <span class="badge bg-info">Для вязки</span>
                <?php endif; ?>
                <p><?= Html::encode($animal->additional_info) ?></p>
                <p class="contact-info">
                    <?php if ($animal->owner): ?>
                        <?php if ($animal->owner->nursery): ?>
                            <?= Html::a(
                                Html::encode($animal->owner->gfn()),
                                ['/nursery/view', 'id' => $animal->owner->nursery->id],
                                ['target' => '_blank']
                            ) ?>
                        <?php else: ?>
                            <?= Html::encode($animal->owner->gfn()) ?>
                        <?php endif; ?>
                    <?php else: ?>
                        Владелец не указан
                    <?php endif; ?>
                    <br>
                    <?= $type === 'sale'
                        ? Html::encode($animal->sale_contacts)
                        : Html::encode($animal->mating_contacts) ?>
                </p>

                <?= Html::a(
                    'Посмотреть родителей', 
                    [$animal_type . '/view', 'id' => $animal->id, 'translit' => $animal->translit], 
                    ['class' => 'btn btn-secondary']
                ) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>