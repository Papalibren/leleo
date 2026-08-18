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

if($type === 'father'){
    $drop = ['кот' => 'Кот'];
}elseif($type === 'mother'){
    $drop = ['кошка' => 'Кошка'];
}

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

    <?= $form->field($model, 'birth_date')->Input('date') ?>

    <?= $form->field($model, 'gender')->dropDownList($drop) ?>

    <?php if (isset($this->params['action']) && $this->params['action'] === 'create'): ?>

        <?= $form->field($model, 'color_id')->dropdownList(
            CatColor::find()->select(['name', 'id'])->indexBy('id')->orderBy('name ASC')->column(),
            ['prompt' => 'Выбрать']
        ) ?>

        <?= $form->field($model, 'pedigree_number')->textInput(['maxlength' => true]) ?>

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