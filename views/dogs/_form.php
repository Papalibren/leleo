<?php

use app\models\DogColor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\file\FileInput;

$dog_colors = DogColor::find()->select(['name', 'id'])->indexBy('id')->orderBy('name ASC')->column();

$this->registerJsFile(
    '@web/js/user-dog.js',
    ['depends' => [\app\assets\AppAsset::class]]
);
$user =  Yii::$app->user->identity;

?>

<div class="dog-form">
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

    <?= $form->field($model, 'breed')->dropDownList([
        'Шпиц' => 'Шпиц',
    ], ['prompt' => 'Выбрать', 'id' => 'dog-breed']) ?>

    <?php if (isset($this->params['action']) && $this->params['action'] === 'create'): ?>

        <?= $form->field($model, 'birth_date')->Input('date') ?>

    <?php endif ?>

    <?= $form->field($model, 'gender')->dropDownList(['кобель' => 'Кобель', 'сука' => 'Сука'], ['prompt' => '']) ?>

    <?php if (isset($this->params['action']) && $this->params['action'] === 'create'): ?>

        <?= $form->field($model, 'color_id')->dropDownList(
            [], // изначально пустой
            [
                'prompt' => 'Сначала выберите породу',
                'id' => 'dog-color-id'
            ]
        ) ?>

        <?= $form->field($model, 'pedigree_number')->textInput(['maxlength' => true]) ?>

    <?php else: ?>

        <div class="alert alert-secondary">
            <strong>Кличка:</strong> <?= Html::encode($model->name) ?><br>
            <strong>Транслит:</strong> <?= Html::encode($model->translit) ?><br>
            <strong>Окрас:</strong> <?= Html::encode($dog_colors[$model->color_id] ?? '—') ?><br>
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
    <label class="col-sm-3 text-end" for="dog-owner-id">
        <?= Html::encode($model->getAttributeLabel('owner_id')) ?>
    </label>
    <div class="col-sm-8 d-flex flex-column gap-2 align-items-start dog-owner_id-mx-box">
        <?= Html::activeInput('text', $model, 'owner_id', [
            'class' => 'form-control',
            'id' => 'dog-owner-id',
            'placeholder' => 'ID или Фамилия',
            'hx-get' => '/mx/dog/create/search-owner',
            'hx-trigger' => 'keyup changed delay:500ms',
            'hx-target' => '#search-results-owner',
        ]) ?>
        <?= Html::button('Указать себя', [
            'class' => 'btn btn-sm btn-outline-secondary align-self-end',
            'data' => ['id' => $user->id, 'first_name' => $user->first_name, 'last_name' => $user->last_name]
        ]) ?>
        <div id="search-results-owner" class="d-flex flex-column justify-content-end align-items-end align-self-end"></div>
    </div>
    <?= Html::error($model, 'owner_id', ['class' => 'invalid-feedback ']) ?>
    <?= $form->endField() ?>
    <!-- Владелец конец -->

    <!-- Заводчик начало -->
    <?= $form->beginField($model, 'breeder_id') ?>
    <label class="col-sm-3 text-end" for="dog-breeder-id">
        <?= Html::encode($model->getAttributeLabel('breeder_id')) ?>
    </label>
    <?php if (!$model->breeder): ?>
        <div class="col-sm-8 d-flex flex-column gap-2 align-items-start dog-breeder_id-mx-box">
            <?= Html::activeInput('text', $model, 'breeder_id', [
                'class' => 'form-control',
                'id' => 'dog-breeder-id',
                'placeholder' => 'ID или Фамилия',
                'hx-get' => '/mx/dog/create/search-breeder',
                'hx-trigger' => 'keyup changed delay:500ms',
                'hx-target' => '#search-results-breeder',
            ]) ?>

            <?= Html::button('Указать себя', [
                'class' => 'btn btn-sm btn-outline-secondary align-self-end',
                'data' => ['id' => $user->id, 'first_name' => $user->first_name, 'last_name' => $user->last_name]
            ]) ?>
            <div id="search-results-breeder" class="d-flex flex-column justify-content-end align-items-end align-self-end"></div>
        </div>
    <?php else: ?>
        <div class="col-sm-8 d-flex flex-column gap-2 align-items-start dog-breeder_id-mx-box" hx-get="/mx/dog/create/select-breeder?breeder_id=<?= $model->breeder->id ?>" hx-trigger="load" hw-swap="outerHTML">
        </div>
    <?php endif ?>
    <?= Html::error($model, 'breeder_id', ['class' => 'invalid-feedback ']) ?>
    <?= $form->endField() ?>
    <!-- Заводчик конец -->

    <!-- Отец начало -->
    <?= $form->beginField($model, 'father_id') ?>
    <label class="col-sm-3 text-end" for="dog-father_id">
        <?= Html::encode($model->getAttributeLabel('father_id')) ?>
    </label>
    <div class="col-sm-8 d-flex flex-column gap-1 align-items-start dog-father_id-mx-box">
        <?php if ($model->father_id): ?>
            <div class="small mb-1">
                Сейчас указан:
                <?= $model->father
                    ? Html::a(Html::encode($model->father->name), ['/dogs/view', 'id' => $model->father_id, 'translit' => $model->father->translit], ['target' => '_blank'])
                    : ('ID ' . Html::encode($model->father_id) . ' (не найден)') ?>
            </div>
        <?php endif ?>
        <?= Html::activeInput('text', $model, 'father_id', [
            'class' => 'form-control',
            'placeholder' => 'ID или кличка',
            'id' => 'dog-father-id',
            'hx-get' => '/mx/dog/create/search-father',
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
    <label class="col-sm-3 text-end" for="dog-mother_id">
        <?= Html::encode($model->getAttributeLabel('mother_id')) ?>
    </label>
    <div class="col-sm-8 d-flex flex-column gap-2 align-items-start dog-mother_id-mx-box">
        <?php if ($model->mother_id): ?>
            <div class="small mb-1">
                Сейчас указана:
                <?= $model->mother
                    ? Html::a(Html::encode($model->mother->name), ['/dogs/view', 'id' => $model->mother_id, 'translit' => $model->mother->translit], ['target' => '_blank'])
                    : ('ID ' . Html::encode($model->mother_id) . ' (не найдена)') ?>
            </div>
        <?php endif ?>
        <?= Html::activeInput('text', $model, 'mother_id', [
            'class' => 'form-control',
            'id' => 'dog-mother_id',
            'placeholder' => 'ID или кличка',
            'hx-get' => '/mx/dog/create/search-mother',
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
                'showUpload' => false,
                'deleteUrl' => \yii\helpers\Url::to(['dog/delete-photo']),
                'sortUrl' => \yii\helpers\Url::to(['dog/sort-photos']),
            ]
        ]) ?>
    <?php endif ?>

    <?php if(!$model->isAncestor()): ?>
        <?= $form->field($documents, 'documentFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    <?php endif ?>

    <div class="row mt-4 mb-2">
        <div class="col-12 col-lg-5 mx-auto">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success w-100']) ?>
        </div>
    </div>

    <?php if (isset($this->params['action']) && $this->params['action'] === 'create'): ?>
        <input type="hidden" name="Dog[user_added_id]" value="<?= $user->id ?>">
    <?php endif ?>
    <?php if (isset($this->params['action']) && $this->params['action'] === 'update'): ?>
        <input type="hidden" name="Dog[user_updated_id]" value="<?= $user->id ?>">
    <?php endif ?>

    <?php ActiveForm::end(); ?>
</div>

<!-- Модальные окна для добавления родителей -->
<div class="modal fade" id="fatherModal" tabindex="-1" aria-labelledby="fatherModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fatherModalLabel">Добавить отца</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="self-add-father-form" hx-post="/mx/dog/create/add-father" hx-target=".dog-father_id-mx-box" hx-on::after-request="closeModal('fatherModal')">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Кличка</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Транслит</label>
                        <input type="text" class="form-control" name="translit" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Родословная</label>
                        <input type="text" class="form-control" name="pedigree_number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Окрас</label>
                        <select class="form-select modal-color-select" name="color_id" required data-breed-select="#dog-breed">
                            <option value="">Сначала выберите породу в основной форме</option>
                        </select>
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

<div class="modal fade" id="motherModal" tabindex="-1" aria-labelledby="motherModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="motherModalLabel">Добавить мать</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="self-add-mother-form" hx-post="/mx/dog/create/add-mother" hx-target=".dog-mother_id-mx-box" hx-on::after-request="closeModal('motherModal')">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Кличка</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Транслит</label>
                        <input type="text" class="form-control" name="translit" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Родословная</label>
                        <input type="text" class="form-control" name="pedigree_number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Окрас</label>
                        <select class="form-select modal-color-select" name="color_id" required data-breed-select="#dog-breed">
                            <option value="">Сначала выберите породу в основной форме</option>
                        </select>
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