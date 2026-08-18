<?php

use app\models\Cat;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
//extract($_POST);
$request = Yii::$app->request;

$cat = new Cat();
$cat->scenario = Cat::SCENARIO_OTHER;
$cat->gender = "кошка";
$cat->name = $request->post('name');
$cat->pedigree_number = $request->post('pedigree_number');;
$cat->translit = $request->post('translit');;
$cat->birth_date = $request->post('birth_date');
$cat->color_id = $request->post('color_id');
$cat->user_added_id = Yii::$app->user->id;

if (!$cat->save()) {
    $error = $cat->getFirstErrors();
    $error = $error[array_key_first($error)];
    $is_saved = false;
} else {
    $is_saved = true;
}

?>
<?php if ($is_saved): ?>
    <?= $cat->name ?>
    <input type="hidden" id="cat-mother-id" class="form-control" name="Cat[mother_id]" placeholder="ID или кличка" value="<?= $cat->id ?>">
<?php else: ?>
    <input type="text" id="cat-mother_id" class="form-control" name="Cat[mother_id]" placeholder="ID или кличка" hx-get="/mx/cat/create/search-mother" hx-trigger="keyup changed delay:500ms" hx-target="#search-results-mother">
    <div id="search-results-mother" class="d-flex"></div>
    <div id="self-add-mother">
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#motherModal">
            Добавить самостоятельно
        </button>
    </div>
    <div class="help-block"><?= Html::encode($error) ?></div>
<?php endif ?>