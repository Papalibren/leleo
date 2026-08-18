<?php

use app\models\Cat;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
//extract($_POST);
$request = Yii::$app->request;

$cat = new Cat();
$cat->scenario = Cat::SCENARIO_OTHER;
$cat->gender = "кот";
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
    <input type="hidden" id="cat-father-id" class="form-control" name="Cat[father_id]" placeholder="ID или кличка" value="<?= $cat->id ?>">
<?php else: ?>
    <input type="text" id="cat-father_id" class="form-control" name="Cat[father_id]" placeholder="ID или кличка" hx-get="/mx/cat/create/search-father" hx-trigger="keyup changed delay:500ms" hx-target="#search-results-father">
    <div id="search-results-father" class="d-flex"></div>
    <div id="self-add-father">
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#fatherModal">
            Добавить самостоятельно
        </button>
    </div>
    <div class="help-block"><?= Html::encode($error) ?></div>
<?php endif ?>