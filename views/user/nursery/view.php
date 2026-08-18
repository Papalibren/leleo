<?php
// views/user/nursery/view.php

use yii\helpers\Html;
use yii\helpers\Url;

// Инициализируем переменные, если они не переданы
$producers = $producers ?? [];
$bornPets = $bornPets ?? [];
?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Питомник "<?= Html::encode($model->title) ?>"</h1>
        <div>
            <?= Html::a('<i class="bi bi-pencil"></i> Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="bi bi-list"></i> Назад к списку', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>

    <!-- Информация о питомнике -->
    <div class="row mb-4">
        <div class="col-md-3 text-center">
            <?php if ($model->photo): ?>
                <img src="/<?= Html::encode($model->photo) ?>" alt="Логотип питомника" class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
            <?php else: ?>
                <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 200px;">
                    <span class="text-muted">Нет логотипа</span>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Основная информация</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Название:</strong> <?= Html::encode($model->title) ?></p>
                            <p><strong>Заводчик:</strong>
                                <?= $model->breeder ? Html::encode($model->breeder->gfn()) : 'не указан' ?>
                            </p>
                            <p><strong>Страна:</strong> <?= $model->country ? Html::encode($model->country) : 'не указана' ?></p>
                            <p><strong>Город:</strong> <?= $model->city ? Html::encode($model->city) : 'не указан' ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Телефон:</strong> <?= $model->phone ? Html::encode($model->phone) : 'не указан' ?></p>
                            <p><strong>Сайт:</strong>
                                <?php if ($model->url): ?>
                                    <?= Html::a(Html::encode($model->url), $model->url, ['target' => '_blank']) ?>
                                <?php else: ?>
                                    не указан
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <?php if ($model->info): ?>
                        <div class="mt-3">
                            <strong>Дополнительная информация:</strong>
                            <div class="border rounded p-3 mt-2 bg-light">
                                <?= nl2br(Html::encode($model->info)) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Вкладки -->
    <ul class="nav nav-tabs" id="kennelTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="producers-tab" data-bs-toggle="tab" data-bs-target="#producers" type="button" role="tab">
                <i class="bi bi-people"></i> Производители питомника
                <span class="badge bg-secondary ms-1"><?= count($producers) ?></span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="born-tab" data-bs-toggle="tab" data-bs-target="#born" type="button" role="tab">
                <i class="bi bi-heart"></i> Родились в питомнике
                <span class="badge bg-secondary ms-1"><?= count($bornPets) ?></span>
            </button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="kennelTabsContent">
        <!-- Производители -->
        <div class="tab-pane fade show active" id="producers" role="tabpanel">
            <div class="row g-3">
                <?php if (!empty($producers)): ?>
                    <?php foreach ($producers as $animal): ?>
                        <div class="col-md-4">
                            <div class="card animal-card h-100">
                                <?php $photo = $animal->getFirstPhoto(); ?>
                                <a href="<?= Url::to([$animal instanceof \app\models\Cat ? 'cats/view' : 'dogs/view', 'id' => $animal->id]); ?>">
                                    <?php if ($photo): ?>
                                        <img src="/<?= Html::encode($photo->image_path) ?>" alt="<?= Html::encode($animal->name) ?>" class="card-img-top img-fluid" style="object-fit: cover; height: 240px;">
                                    <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 240px;">
                                            <span class="text-muted">Нет фото</span>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title"><?= Html::encode($animal->name) ?></h5>
                                    <p class="card-text">
                                        <strong>Тип:</strong> <?= $animal instanceof \app\models\Cat ? 'Кошка' : 'Собака' ?><br>
                                        <strong>Порода:</strong> <?= Html::encode($animal->breed) ?><br>
                                        <strong>Дата рождения:</strong> <?= Yii::$app->formatter->asDate($animal->birth_date) ?><br>
                                        <strong>Пол:</strong> <?= Html::encode($animal->gender) ?><br>
                                        <strong>Родословная:</strong> <?= Html::encode($animal->pedigree_number) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> В этом питомнике пока нет зарегистрированных производителей.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Родились в питомнике -->
        <div class="tab-pane fade" id="born" role="tabpanel">
            <div class="row g-3">
                <?php if (!empty($bornPets)): ?>
                    <?php foreach ($bornPets as $pet): ?>
                        <div class="col-md-4">
                            <div class="card animal-card h-100">
                                <?php $photo = $pet->getFirstPhoto(); ?>
                                <a href="<?= Url::to([$pet instanceof \app\models\Cat ? 'cats/view' : 'dogs/view', 'id' => $pet->id]); ?>">
                                    <?php if ($photo): ?>
                                        <img src="/<?= Html::encode($photo->image_path) ?>" alt="<?= Html::encode($pet->name) ?>" class="card-img-top img-fluid" style="object-fit: cover; height: 240px;">
                                    <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 240px;">
                                            <span class="text-muted">Нет фото</span>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title"><?= Html::encode($pet->name) ?></h5>
                                    <p class="card-text">
                                        <strong>Тип:</strong> <?= $pet instanceof \app\models\Cat ? 'Кошка' : 'Собака' ?><br>
                                        <strong>Порода:</strong> <?= Html::encode($pet->breed) ?><br>
                                        <strong>Дата рождения:</strong> <?= Yii::$app->formatter->asDate($pet->birth_date) ?><br>
                                        <strong>Пол:</strong> <?= Html::encode($pet->gender) ?><br>
                                        <strong>Родословная:</strong> <?= Html::encode($pet->pedigree_number) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> В этом питомнике пока нет зарегистрированных рождений.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>