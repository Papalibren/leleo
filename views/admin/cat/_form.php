<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Cat $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'translit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'breed')->dropDownList([ 'Бенгальская' => 'Бенгальская', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'birth_date')->textInput() ?>

    <?= $form->field($model, 'gender')->dropDownList([ 'кот' => 'Кот', 'кошка' => 'Кошка', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'color_id')->textInput() ?>

    <?= $form->field($model, 'pedigree_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_for_mating')->textInput() ?>

    <?= $form->field($model, 'mating_contacts')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_for_sale')->textInput() ?>

    <?= $form->field($model, 'sale_contacts')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'owner_id')->textInput() ?>

    <?= $form->field($model, 'breeder_id')->textInput() ?>

    <?= $form->field($model, 'father_id')->textInput() ?>

    <?= $form->field($model, 'mother_id')->textInput() ?>

    <?= $form->field($model, 'titles')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'additional_info')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
