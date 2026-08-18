<?php
// views/user/nursery/_form.php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Nursery $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerJsFile(
    '@web/js/user-nursey.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
$user = Yii::$app->user->identity;
?>

<div class="nursery-form">

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
    ]); ?>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Основная информация</h5>
        </div>
        <div class="card-body">
            <?= $form->field($model, 'title')->textInput([
                'maxlength' => true,
                'placeholder' => 'Введите название питомника'
            ]) ?>

            <?= $form->field($model, 'breeder_id')->textInput([
                'type' => 'hidden'
            ])->label(false) ?>

            <div class="row mb-3">
                <label class="col-sm-3 text-end">Заводчик</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control" id="breeder-display"
                               value="<?= $model->breeder ? $model->breeder->gfn() : '' ?>"
                               placeholder="Выберите заводчика" readonly>
                        <button type="button" class="btn btn-outline-secondary" id="select-breeder-btn">
                            Выбрать себя
                        </button>
                    </div>
                    <div class="form-text">Текущий пользователь: <?= $user->gfn() ?></div>
                </div>
            </div>

            <?= $form->field($model, 'imageFile')->fileInput([
                'accept' => 'image/*'
            ]) ?>

            <?php if ($model->photo): ?>
                <div class="row mb-3">
                    <label class="col-sm-3 text-end">Текущее фото</label>
                    <div class="col-sm-8">
                        <?= Html::img('/' . $model->photo, [
                            'style' => 'max-height: 100px;',
                            'class' => 'img-thumbnail'
                        ]) ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Контактная информация</h5>
        </div>
        <div class="card-body">
            <?= $form->field($model, 'country')->textInput([
                'maxlength' => true,
                'placeholder' => 'Страна'
            ]) ?>

            <?= $form->field($model, 'city')->textInput([
                'maxlength' => true,
                'placeholder' => 'Город'
            ]) ?>

            <?= $form->field($model, 'phone')->textInput([
                'maxlength' => true,
                'placeholder' => '+7 (XXX) XXX-XX-XX'
            ]) ?>

            <?= $form->field($model, 'url')->textInput([
                'maxlength' => true,
                'placeholder' => 'https://example.com'
            ]) ?>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Дополнительная информация</h5>
        </div>
        <div class="card-body">
            <?= $form->field($model, 'info')->textarea([
                'rows' => 6,
                'placeholder' => 'Описание питомника, история, достижения...'
            ]) ?>
        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectBreederBtn = document.getElementById('select-breeder-btn');
    const breederIdInput = document.getElementById('nursery-breeder_id');
    const breederDisplay = document.getElementById('breeder-display');

    selectBreederBtn.addEventListener('click', function() {
        breederIdInput.value = '<?= $user->id ?>';
        breederDisplay.value = '<?= $user->gfn() ?>';
    });
});
</script>