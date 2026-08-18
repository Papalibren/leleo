<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\View;

/** @var \app\models\Cat $model */

// 1) Подключаем CSS (обязательно для Swiper/GLightbox)
$this->registerCssFile('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
$this->registerCssFile('https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css');

// 2) Подключаем JS
$this->registerJsFile('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);

// 3) Готовим данные для слайдера
$photos = $model->getPhotos();
$slidesCount = is_array($photos) ? count($photos) : 0;

// 4) Проверяем наличие родителей
$hasFather = !empty($model->father_id);
$hasMother = !empty($model->mother_id);

// 5) Инициализация слайдера и лайтбокса
$this->registerJs(<<<JS
  (function(){
    var slidesCount = {$slidesCount};
    var useLoop = slidesCount > 1;

    var swiper = new Swiper(".swiper", {
      loop: useLoop,
      observer: true,
      observeParents: true,
      keyboard: {
        enabled: true,
        onlyInViewport: true
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true
      }
    });

    // Прячем стрелки/пагинацию если 1 слайд
    if (slidesCount <= 1) {
      document.querySelectorAll(".swiper-button-next, .swiper-button-prev, .swiper-pagination")
        .forEach(function(el){ el.style.display = "none"; });
    }

    GLightbox({
      selector: ".glightbox",
      touchNavigation: true,
      keyboardNavigation: true
    });
  })();
JS);

?>

<div class="container mt-4">
    <div class="card animal-card p-4">
        <?php if (!$model->owner): ?>
            <div class="row">
                <div class="col-12 text-end">
                    <a class="btn btn-primary btn-sm" href="/cats/edit/?id=<?= $model->id ?>" title="Просмотр">
                        Редактировать <i class="bi bi-pencil ms-2"></i>
                    </a>
                </div>
            </div>
        <?php endif ?>

        <div class="row">
            <h2 class="text-center"><?= Html::encode($model->name) ?></h2>
            <?php if (!$model->is_active): ?>
                <div class="col-12 text-start">
                    <span class="badge bg-warning text-dark ms-2">На модерации</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <p><strong>Порода:</strong> Бенгальская</p>
                <p><strong>Дата рождения:</strong> <?= Yii::$app->formatter->asDate($model->birth_date, 'php:d.m.Y') ?></p>
                <p><strong>Пол:</strong> <?= Html::encode($model->gender) ?></p>

                <?php
                // Заводчик
                $breederNurseryLink = null;
                if ($model->breeder && $model->breeder->nursery) {
                    $breederNurseryLink = Html::a(
                        Html::encode($model->breeder->nursery->title),
                        ['/nursery/view', 'id' => $model->breeder->nursery->id],
                        ['target' => '_blank']
                    );
                }
                ?>
                <p>
                    <strong>Заводчик:</strong>
                    <?= $model->breeder ? Html::encode($model->breeder->gfn()) : 'Не указан' ?>
                </p>

                <?php if ($breederNurseryLink): ?>
                    <p><strong>Питомник:</strong> <?= $breederNurseryLink ?></p>
                <?php endif; ?>

                <?php
                // Владелец
                $ownerNurseryLink = null;
                if ($model->owner && $model->owner->nursery) {
                    $ownerNurseryLink = Html::a(
                        Html::encode($model->owner->nursery->title),
                        ['/nursery/view', 'id' => $model->owner->nursery->id],
                        ['target' => '_blank']
                    );
                }
                ?>
                <p>
                    <strong>Владелец:</strong>
                    <?= $model->owner ? Html::encode($model->owner->gfn()) : 'Не указан' ?>
                </p>

                <p><strong>Окрас:</strong> <?= Html::encode($model->color->name) ?></p>
                <p><strong>Родословная:</strong> <?= Html::encode($model->pedigree_number) ?></p>
                <p><strong>Чип:</strong> <?= Html::encode($model->chip)?></p>
                <!-- Кнопки добавления родителей, если они отсутствуют -->
                <?php if (!$hasFather || !$hasMother): ?>
                                     <div class="d-flex gap-2 flex-wrap">
                                        <?php if (!$hasFather): ?>
                                            <?= Html::a(
                                                '<i class="bi bi-gender-male me-2"></i>Добавить отца',
                                                "/user/cat/create-parent?type=father&child_id={$model->id}",
                                                [
                                                    'class' => 'btn btn-danger',
                                                    'title' => 'Добавить отца',
                                                    'role'  => 'button',
                                                ]
                                            ) ?>
                                        <?php endif; ?>

                                        <?php if (!$hasMother): ?>
                                            <?= Html::a(
                                                '<i class="bi bi-gender-female me-2"></i>Добавить мать',
                                                "/user/cat/create-parent?type=mother&child_id={$model->id}",
                                                [
                                                    'class' => 'btn btn-warning',
                                                    'title' => 'Добавить мать',
                                                    'role'  => 'button',
                                                ]
                                            ) ?>
                                        <?php endif; ?>
                                    </div>
                <?php endif; ?>
                <?php
                // Метки объявлений
                $announcementLinks = [];
                if ($model->is_for_sale) {
                    $announcementLinks[] = Html::a(
                        '<span class="badge bg-success me-1">В продаже</span>',
                        Url::to(['/announcement/index', 'animal_type' => 'cats', 'type' => 'sale', 'cat_id' => $model->id])
                    );
                }
                if ($model->is_for_mating) {
                    $announcementLinks[] = Html::a(
                        '<span class="badge bg-primary me-1">Для вязки</span>',
                        Url::to(['/announcement/index', 'animal_type' => 'cats', 'type' => 'mating', 'cat_id' => $model->id])
                    );
                }
                if (!empty($announcementLinks)) {
                    echo '<p class="mt-3">' . implode(' ', $announcementLinks) . '</p>';
                }
                ?>
            </div>

            <div class="col-12 col-lg-6">
                <!-- Важно: контейнер именно .swiper для Swiper v11 -->
                <div class="swiper">
                    <div class="swiper-wrapper">
                        <?php if ($slidesCount): ?>
                            <?php foreach ($photos as $photo): ?>
                                <?php if (!isset($photo->image_path) || !$photo->image_path) continue; ?>
                                <div class="swiper-slide text-center">
                                    <a href="/<?= Html::encode($photo->image_path) ?>"
                                        class="glightbox"
                                        data-gallery="cat-gallery"
                                        data-title="<?= Html::encode($model->name) ?>">
                                        <img src="/<?= Html::encode($photo->image_path) ?>"
                                            class="img-fluid rounded"
                                            style="max-height:500px;width:auto;margin:0 auto;"
                                            alt="<?= Html::encode($model->name) ?>">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Фолбэк на случай полного отсутствия -->
                            <div class="swiper-slide text-center">
                                <img src="/img/default-cat.webp"
                                    class="img-fluid rounded"
                                    style="max-height:500px;width:auto;margin:0 auto;"
                                    alt="<?= Html::encode($model->name) ?>">
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Навигация/Пагинация -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs mt-3" id="animalTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pedigree-tab" data-bs-toggle="tab" data-bs-target="#pedigree" type="button" role="tab">Родословная</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="siblings-tab" data-bs-toggle="tab" data-bs-target="#siblings" type="button" role="tab">Сибсы</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="offspring-tab" data-bs-toggle="tab" data-bs-target="#offspring" type="button" role="tab">Дети</button>
        </li>
    </ul>

    <div class="tab-content mt-2" id="animalTabContent">
        <div class="tab-pane fade show active" id="pedigree" role="tabpanel">
            <?= \app\widgets\AncestorsTableWidget::widget(['model' => $model]) ?>
        </div>
        <div class="tab-pane fade" id="siblings" role="tabpanel">
            <?= \app\widgets\SiblingsWidget::widget(['model' => $model]) ?>
        </div>
        <div class="tab-pane fade" id="offspring" role="tabpanel">
            <?= \app\widgets\ChildrenWidget::widget(['model' => $model]) ?>
        </div>
    </div>
</div>