<?php
// views/user/dog/_form-parent.php

use app\models\DogColor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\file\FileInput;

$dog_colors = DogColor::find()->select(['name', 'id'])->indexBy('id')->orderBy('name ASC')->column();

$this->registerJsFile(
    '@web/js/user-dog.js',
    ['depends' => [\app\assets\AppAsset::class]]
);
$user = Yii::$app->user->identity;

if ($type === 'father') {
    $drop = ['кобель' => 'Кобель'];
    $title = 'Отца';
} else {
    $drop = ['сука' => 'Сука'];
    $title = 'Мать';
}

// JavaScript для обновления цветов в зависимости от породы
$this->registerJs(<<<JS
    $(document).ready(function() {
        // Обработчик изменения породы
        $('#dog-breed').change(function() {
            var breed = $(this).val();
            var colorSelect = $('#dog-color-id');

            if (breed) {
                // Показываем индикатор загрузки
                colorSelect.html('<option value="">Загрузка...</option>');

                // AJAX запрос для получения цветов
                $.get('/dog/get-colors', { breed: breed }, function(data) {
                    var options = '<option value="">Выбрать цвет</option>';

                    $.each(data, function(id, name) {
                        options += '<option value="' + id + '">' + name + '</option>';
                    });

                    colorSelect.html(options);
                });
            } else {
                colorSelect.html('<option value="">Сначала выберите породу</option>');
            }
        });

        // Инициализация при загрузке страницы
        var initialBreed = $('#dog-breed').val();
        if (initialBreed) {
            $('#dog-breed').trigger('change');
        }
    });
JS);
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

    <h3 class="text-center mb-4">Добавление <?= $title ?></h3>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'translit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'breed')->dropDownList([
        'Шпиц' => 'Шпиц',
        'Тибетский мастиф' => 'Тибетский мастиф',
    ], ['prompt' => 'Выбрать', 'id' => 'dog-breed']) ?>

    <?= $form->field($model, 'birth_date')->input('date') ?>

    <?= $form->field($model, 'gender')->dropDownList($drop) ?>

    <?= $form->field($model, 'color_id')->dropDownList(
        [], // изначально пустой
        [
            'prompt' => 'Сначала выберите породу',
            'id' => 'dog-color-id'
        ]
    ) ?>

    <?= $form->field($model, 'pedigree_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chip')->textInput(['maxlength' => true]) ?>

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
    <?= Html::error($model, 'breeder_id', ['class' => 'invalid-feedback ']) ?>
    <?= $form->endField() ?>
    <!-- Заводчик конец -->

    <?= $form->field($model, 'titles')->textarea(['rows' => 6]) ?>

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

    <div class="row mt-4 mb-2">
        <div class="col-12 col-lg-5 mx-auto">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success w-100']) ?>
        </div>
    </div>

    <input type="hidden" name="Dog[user_added_id]" value="<?= $user->id ?>">
    <input type="hidden" name="type" value="<?= $type ?>">
    <input type="hidden" name="child_id" value="<?= $child_id ?>">

    <?php ActiveForm::end(); ?>
</div>