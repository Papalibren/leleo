<?php

use app\models\CatColor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\file\FileInput;

$cat_colors = CatColor::find()->select(['name', 'id'])->indexBy('id')->orderBy('name ASC')->column();


$this->registerJsFile(
    '@web/js/user-cat.js',
    ['depends' => [\app\assets\AppAsset::class]]
);
$user =  Yii::$app->user->identity;


?>

<div class="cat-form">
    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-3 text-end',
                'offset' => 'offset-sm-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],
        'options' => ['class' => 'container mt-4 p-4 border rounded bg-info-subtle']
    ]); ?>

    <?php if (isset($this->params['action']) && $this->params['action'] === 'create'): ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'translit')->textInput(['maxlength' => true]) ?>

    <?php endif ?>

    <?= $form->field($model, 'breed')->dropDownList(['Бенгальская' => 'Бенгальская',], ['prompt' => '']) ?>

    <?php if (isset($this->params['action']) && $this->params['action'] === 'create'): ?>

        <?= $form->field($model, 'birth_date')->Input('date') ?>

    <?php endif ?>

    <?= $form->field($model, 'gender')->dropDownList(['кот' => 'Кот', 'кошка' => 'Кошка',], ['prompt' => '']) ?>

    <?php if (isset($this->params['action']) && $this->params['action'] === 'create'): ?>

        <?= $form->field($model, 'color_id')->dropdownList(
            CatColor::find()->select(['name', 'id'])->indexBy('id')->orderBy('name ASC')->column(),
            ['prompt' => 'Выбрать']
        ) ?>

        <?= $form->field($model, 'pedigree_number')->textInput(['maxlength' => true]) ?>

    <?php else: ?>

        <div class="alert alert-secondary">
            <strong>Кличка:</strong> <?= Html::encode($model->name) ?><br>
            <strong>Транслит:</strong> <?= Html::encode($model->translit) ?><br>
            <strong>Окрас:</strong> <?= Html::encode($cat_colors[$model->color_id] ?? '—') ?><br>
            <strong>Номер родословной:</strong> <?= Html::encode($model->pedigree_number) ?><br>
            <strong>Дата рождения:</strong> <?= Html::encode($model->birth_date ?: '—') ?>
            <div class="small text-muted mt-1">Эти поля сверяются с документами и не редактируются после создания.</div>
        </div>

    <?php endif ?>

    <?= $form->field($model, 'chip')->textInput(['maxlength' => true]) ?>

    <!-- Для продвинутых -->
    <?php if (Yii::$app->user->identity->is_advanced): ?>
        <!--Для вязки -->
        <?= $form->field($model, 'is_for_mating', [
            'template' => '
        <div class="col-12 col-sm-8">
            <div class="form-check">
                {input}
                {label}
                {error}
            </div>
        </div>',
            'horizontalCssClasses' => [
                'label' => 'col-12',
                'offset' => 'offset-sm-3',
                'wrapper' => 'col-12',
                'error' => '',
                'hint' => '',
            ],
            'labelOptions' => ['class' => 'form-check-label'],
        ])->checkbox(['class' => 'form-check-input'], false) ?>


        <?= $form->field($model, 'mating_contacts')->textarea(['rows' => 2]) ?>


        <!--Для продажи -->
        <?= $form->field($model, 'is_for_sale', [
            'template' => '
        <div class="col-12 col-sm-8">
            <div class="form-check">
                {input}
                {label}
                {error}
            </div>
        </div>',
            'horizontalCssClasses' => [
                'label' => 'col-12',
                'offset' => 'offset-sm-3',
                'wrapper' => 'col-12',
                'error' => '',
                'hint' => '',
            ],
            'labelOptions' => ['class' => 'form-check-label'],
        ])->checkbox(['class' => 'form-check-input'], false) ?>

        <?= $form->field($model, 'price')->input('number') ?>

        <?= $form->field($model, 'sale_contacts')->textarea(['rows' => 2]) ?>


    <?php else: ?>
        <?= $form->field($model, 'is_for_mating', [
            'template' => '
        <div class="col-12 col-sm-8">
            <div class="form-check">
                {input}
                {label}
                {error}
            </div>
            {hint}
        </div>',
            'horizontalCssClasses' => [
                'label' => 'col-12',
                'offset' => 'offset-sm-3',
                'wrapper' => 'col-12',
                'error' => '',
                'hint' => '',
            ],
            'labelOptions' => ['class' => 'form-check-label'],
        ])->checkbox(['class' => 'form-check-input', 'disabled' => true], false)
            ->hint('<span class="badge text-bg-danger">Доступно только для продвинутых пользователей</span>')
        ?>
        <?= $form->field($model, 'is_for_sale', [
            'template' => '
        <div class="col-12 col-sm-8">
            <div class="form-check">
                {input}
                {label}
                {error}
            </div>
            {hint}
        </div>',
            'horizontalCssClasses' => [
                'label' => 'col-12',
                'offset' => 'offset-sm-3',
                'wrapper' => 'col-12',
                'error' => '',
                'hint' => '',
            ],
            'labelOptions' => ['class' => 'form-check-label'],
        ])->checkbox(['class' => 'form-check-input', 'disabled' => true], false)
            ->hint('<span class="badge text-bg-danger">Доступно только для продвинутых пользователей</span>')
        ?>
    <?php endif ?>

    <!-- Для продвинутых /-->

    <!-- Владелец начало -->
    <?= $form->beginField($model, 'owner_id') ?>
    <label class="col-sm-3 text-end" for="cat-owner-id">
        <?= Html::encode($model->getAttributeLabel('owner_id')) ?>
    </label>
    <?php if (isset($this->params['action']) && $this->params['action'] === 'create'): ?>
        <div class="col-sm-8 d-flex flex-column gap-2 align-items-start cat-owner_id-mx-box">
            <?= Html::activeInput('text', $model, 'owner_id', [
                'class' => 'form-control',
                'id' => 'cat-owner-id',
                'placeholder' => 'ID или Фамилия',
                'hx-get' => '/mx/cat/create/search-owner',
                'hx-trigger' => 'keyup changed delay:500ms',
                'hx-target' => '#search-results-owner',
            ]) ?>
            <?= Html::button('Указать себя', [
                'class' => 'btn btn-sm btn-outline-secondary align-self-end',
                'data' => ['id' => $user->id, 'first_name' => $user->first_name, 'last_name' => $user->last_name]

            ]) ?>
            <div id="search-results-owner" class="d-flex flex-column justify-content-end align-items-end align-self-end"></div>
        </div>
    <?php endif ?>
    <?php if (isset($this->params['action']) && $this->params['action'] === 'update'): ?>
        <div class="col-sm-8 d-flex flex-column gap-2 align-items-start cat-owner_id-mx-box" hx-get="/mx/cat/create/select-owner?owner_id=<?= $model->owner->id ?>" hx-trigger="load" hw-swap="outerHTML">
        </div>
    <?php endif ?>
    <?= Html::error($model, 'owner_id', ['class' => 'invalid-feedback ']) ?>
    <?= $form->endField() ?>
    <!-- Владелец конец -->

    <!-- Заводчик начало -->
    <?= $form->beginField($model, 'breeder_id') ?>
    <label class="col-sm-3 text-end" for="cat-breeder-id">
        <?= Html::encode($model->getAttributeLabel('breeder_id')) ?>
    </label>
    <?php if (isset($this->params['action']) && $this->params['action'] === 'create'): ?>
        <div class="col-sm-8 d-flex flex-column gap-2 align-items-start cat-breeder_id-mx-box">
            <?= Html::activeInput('text', $model, 'breeder_id', [
                'class' => 'form-control',
                'id' => 'cat-breeder-id',
                'placeholder' => 'ID или Фамилия',
                'hx-get' => '/mx/cat/create/search-breeder',
                'hx-trigger' => 'keyup changed delay:500ms',
                'hx-target' => '#search-results-breeder',
            ]) ?>

            <?= Html::button('Указать себя', [
                'class' => 'btn btn-sm btn-outline-secondary align-self-end',
                'data' => ['id' => $user->id, 'first_name' => $user->first_name, 'last_name' => $user->last_name]
            ]) ?>
            <div id="search-results-breeder" class="d-flex flex-column justify-content-end align-items-end align-self-end"></div>
        </div>
    <?php endif ?>
    <?php if (isset($this->params['action']) && $this->params['action'] === 'update'): ?>
        <div class="col-sm-8 d-flex flex-column gap-2 align-items-start cat-breeder_id-mx-box" hx-get="/mx/cat/create/select-breeder?breeder_id=<?= $model->breeder->id ?>" hx-trigger="load" hw-swap="outerHTML">
        </div>
    <?php endif ?>
    <?= Html::error($model, 'breeder_id', ['class' => 'invalid-feedback ']) ?>
    <?= $form->endField() ?>
    <!-- Заводчик конец -->

    <!-- Отец начало -->
    <?= $form->beginField($model, 'father_id') ?>
    <label class="col-sm-3 text-end" for="cat-father_id">
        <?= Html::encode($model->getAttributeLabel('father_id')) ?>
    </label>
    <div class="col-sm-8 d-flex flex-column gap-1 align-items-start cat-father_id-mx-box">
        <?php if ($model->father_id): ?>
            <div class="small mb-1">
                Сейчас указан:
                <?= $model->father
                    ? Html::a(Html::encode($model->father->name), ['/cats/view', 'id' => $model->father_id, 'translit' => $model->father->translit], ['target' => '_blank'])
                    : ('ID ' . Html::encode($model->father_id) . ' (не найден)') ?>
            </div>
        <?php endif ?>
        <?= Html::activeInput('text', $model, 'father_id', [
            'class' => 'form-control',
            'placeholder' => 'ID или кличка',
            'id' => 'cat-father-id',
            'hx-get' => '/mx/cat/create/search-father',
            'hx-trigger' => 'keyup changed delay:500ms',
            'hx-target' => '#search-results-father',
        ]) ?>
        <div id="search-results-father" class="d-flex"></div>
        <div id="self-add-father">
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#fatherModal">
                Добавить самостоятельно
            </button>
        </div>
    </div>
    <?= Html::error($model, 'father_id', ['class' => 'invalid-feedback ']) ?>
    <?= $form->endField() ?>
    <!-- Отец конец -->

    <!-- Мать начало -->
    <?= $form->beginField($model, 'mother_id') ?>
    <label class="col-sm-3 text-end" for="cat-mother_id">
        <?= Html::encode($model->getAttributeLabel('mother_id')) ?>
    </label>
    <div class="col-sm-8 d-flex flex-column gap-2 align-items-start cat-mother_id-mx-box">
        <?php if ($model->mother_id): ?>
            <div class="small mb-1">
                Сейчас указана:
                <?= $model->mother
                    ? Html::a(Html::encode($model->mother->name), ['/cats/view', 'id' => $model->mother_id, 'translit' => $model->mother->translit], ['target' => '_blank'])
                    : ('ID ' . Html::encode($model->mother_id) . ' (не найдена)') ?>
            </div>
        <?php endif ?>
        <?= Html::activeInput('text', $model, 'mother_id', [
            'class' => 'form-control',
            'id' => 'cat-mother_id',
            'placeholder' => 'ID или кличка',
            'hx-get' => '/mx/cat/create/search-mother',
            'hx-trigger' => 'keyup changed delay:500ms',
            'hx-target' => '#search-results-mother',
        ]) ?>
        <div id="search-results-mother" class="d-flex"></div>
        <div id="self-add-mother">
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#motherModal">
                Добавить самостоятельно
            </button>
        </div>
        <?= Html::error($model, 'mother_id', ['class' => 'help-block']) ?>
    </div>
    <?= $form->endField() ?>
    <!-- Мать конец -->

    <?= $form->field($model, 'titles')->textarea(['rows' => 6]) ?>

    <!-- Для продвинутых -->

    <?php if (Yii::$app->user->identity->is_advanced): ?>
        <?= $form->field($model, 'additional_info')->textarea(['rows' => 6]) ?>
    <?php endif ?>

    <!-- Для продвинутых /-->

    <?php if (isset($this->params['action']) && $this->params['action'] === 'create'): ?>
        <?= $form->field($photos, 'imageFiles[]')->widget(FileInput::class, [
            'options' => ['multiple' => true, 'accept' => 'image/*'],
            'pluginOptions' => [
                'previewFileType' => 'image',
                'maxFileCount' => 3,
                'sortable' => true,
                'browseLabel' => 'Выбрать фото',
                'removeLabel' => 'Удалить',
                'uploadLabel' => false,
                'showUpload' => false,
                'initialPreviewAsData' => true,
                'overwriteInitial' => false,
                // можно подключить текущие изображения, если редактирование
            ]
        ]) ?>
    <?php endif ?>
    <?php if (isset($this->params['action']) && $this->params['action'] === 'update'): ?>
        <?= $form->field($photos, 'imageFiles[]')->widget(FileInput::class, [
            'options' => ['multiple' => true, 'accept' => 'image/*'],
            'pluginOptions' => [
                'initialPreview' => $initialPreview,
                'initialPreviewAsData' => true,
                'initialPreviewConfig' => $initialPreviewConfig,
                'overwriteInitial' => false,
                'maxFileCount' => 3,
                //'sortable' => true,
                'showUpload' => false,
                'deleteUrl' => \yii\helpers\Url::to(['cat/delete-photo']),
                'sortUrl' => \yii\helpers\Url::to(['cat/sort-photos']),
            ]
        ]) ?>
    <?php endif ?>


    <?php if (isset($this->params['action']) && $this->params['action'] === 'create'): ?>

        <?= $form->field($documents, 'documentFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <?php endif ?>

    <div class="row mt-4 mb-2">
        <div class="col-12 col-lg-5 mx-auto">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success w-100']) ?>
        </div>
    </div>

    <?php if (isset($this->params['action']) && $this->params['action'] === 'create'): ?>
    <input type="hidden" name="Cat[user_added_id]" value="<?=$user -> id?>">
    <?php endif ?>
    <?php if (isset($this->params['action']) && $this->params['action'] === 'update'): ?>
    <input type="hidden" name="Cat[user_updated_id]" value="<?=$user -> id?>">
    <?php endif ?>

    <?php ActiveForm::end(); ?>

</div>

<div class="modal fade" id="fatherModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Добавить отца</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="self-add-father-form" hx-post="/mx/cat/create/add-father" hx-target=".cat-father_id-mx-box" hx-on::after-request="closeModal('fatherModal')">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Кличка</label>
                        <input type="text" class="form-control" id="self-father-name" name="name" required>
                        <div id="" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Транслит</label>
                        <input type="text" class="form-control" id="self-father-translit" name="translit" required>
                        <div id="" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Родословная</label>
                        <input type="text" class="form-control" id="" name="pedigree_number" required>
                        <div id="" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Окрас</label>
                        <select class="form-select" name="color_id" required>
                            <option value="">Выбрать окрас</option>
                            <?php foreach ($cat_colors as $k => $cc): ?>
                                <option value="<?= $k ?>"><?= $cc ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="" class="form-text"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="motherModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Добавить мать</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="self-add-mother-form" hx-post="/mx/cat/create/add-mother" hx-target=".cat-mother_id-mx-box" hx-on::after-request="closeModal('motherModal')">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Кличка</label>
                        <input type="text" class="form-control" id="self-mother-name" name="name" required>
                        <div id="" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Транслит</label>
                        <input type="text" class="form-control" id="self-mother-translit" name="translit" required>
                        <div id="" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Родословная</label>
                        <input type="text" class="form-control" id="" name="pedigree_number" required>
                        <div id="" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Окрас</label>
                        <select class="form-select" name="color_id" required>
                            <option value="">Выбрать окрас</option>
                            <?php foreach ($cat_colors as $k => $cc): ?>
                                <option value="<?= $k ?>"><?= $cc ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="" class="form-text"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>