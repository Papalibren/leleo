<?php
// views/nursery/view.php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="container py-5">
    <h1 class="mb-4">Питомник <?= Html::encode($model->title) ?> </h1>

    <!-- Информация о питомнике -->
    <div class="row mb-4">
        <div class="col-md-3 text-center">
            <?php if ($model->photo): ?>
                <img src="/<?= Html::encode($model->photo) ?>" alt="Логотип питомника" class="kennel-logo mb-2 img-fluid" style="max-height: 200px; object-fit: cover;">
            <?php else: ?>
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <span class="text-muted">Нет логотипа</span>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-9">
            <table class="table table-bordered bg-white">
                <tbody>
                    <tr>
                        <th>Заводчик</th>
                        <td>
                            <?php if ($model->breeder): ?>
                                <?= Html::encode($model->breeder->gfn()) ?>
                            <?php else: ?>
                                не указан
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Сайт</th>
                        <td>
                            <?php if ($model->url): ?>
                                <a href="<?= Html::encode($model->url) ?>" target="_blank"><?= Html::encode($model->url) ?></a>
                            <?php else: ?>
                                не указан
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Страна</th>
                        <td><?= $model->country ? Html::encode($model->country) : 'не указана' ?></td>
                    </tr>
                    <tr>
                        <th>Город</th>
                        <td><?= $model->city ? Html::encode($model->city) : 'не указан' ?></td>
                    </tr>
                    <tr>
                        <th>Телефон</th>
                        <td><?= $model->phone ? Html::encode($model->phone) : 'не указан' ?></td>
                    </tr>
                    <tr>
                        <th>Информация</th>
                        <td><?= $model->info ? nl2br(Html::encode($model->info)) : 'не указана' ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Меню фильтрации -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Фильтр животных</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Тип животного:</label>
                            <div class="btn-group-vertical w-100">
                                <?php foreach ($animalTypes as $key => $label): ?>
                                    <?= Html::a($label, ['view', 'id' => $model->id, 'animal_type' => $key, 'dog_breed' => $dog_breed], [
                                        'class' => 'btn btn-outline-primary text-start' . ($animal_type === $key ? ' active' : '')
                                    ]) ?>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <?php if ($animal_type === 'dogs' || $animal_type === 'all'): ?>
                        <div class="col-md-4">
                            <label class="form-label">Порода собак:</label>
                            <div class="btn-group-vertical w-100">
                                <?php foreach ($dogBreeds as $key => $label): ?>
                                    <?= Html::a($label, ['view', 'id' => $model->id, 'animal_type' => $animal_type, 'dog_breed' => $key], [
                                        'class' => 'btn btn-outline-secondary text-start' . ($dog_breed === $key ? ' active' : '')
                                    ]) ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="col-md-4">
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="mb-2">
                                    <strong>Найдено:</strong>
                                    <span class="badge bg-primary"><?= count($producers) + count($bornPets) ?> животных</span>
                                </div>
                                <?php if ($animal_type === 'dogs' && $dog_breed): ?>
                                    <div class="text-muted">
                                        <small>Фильтр: Собаки → <?= $dogBreeds[$dog_breed] ?></small>
                                    </div>
                                <?php elseif ($animal_type !== 'all'): ?>
                                    <div class="text-muted">
                                        <small>Фильтр: <?= $animalTypes[$animal_type] ?></small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Вкладки -->
    <ul class="nav nav-tabs" id="kennelTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="producers-tab" data-bs-toggle="tab" data-bs-target="#producers" type="button" role="tab">
                Производители питомника
                <span class="badge bg-secondary ms-1"><?= count($producers) ?></span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="born-tab" data-bs-toggle="tab" data-bs-target="#born" type="button" role="tab">
                Родились в питомнике
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
                            <?php if ($animal_type === 'all'): ?>
                                В этом питомнике пока нет зарегистрированных производителей.
                            <?php elseif ($animal_type === 'cats'): ?>
                                В этом питомнике пока нет зарегистрированных кошек-производителей.
                            <?php else: ?>
                                <?php if ($dog_breed): ?>
                                    В этом питомнике пока нет собак породы "<?= $dogBreeds[$dog_breed] ?>" производителей.
                                <?php else: ?>
                                    В этом питомнике пока нет зарегистрированных собак-производителей.
                                <?php endif; ?>
                            <?php endif; ?>
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
                            <?php if ($animal_type === 'all'): ?>
                                В этом питомнике пока нет зарегистрированных рождений.
                            <?php elseif ($animal_type === 'cats'): ?>
                                В этом питомнике пока нет зарегистрированных рождений кошек.
                            <?php else: ?>
                                <?php if ($dog_breed): ?>
                                    В этом питомнике пока нет рождений собак породы "<?= $dogBreeds[$dog_breed] ?>".
                                <?php else: ?>
                                    В этом питомнике пока нет зарегистрированных рождений собак.
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>