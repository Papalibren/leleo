<?php

use app\models\dog;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
//extract($_POST);
$request = Yii::$app->request;

$dog = new dog();
$dog->scenario = dog::SCENARIO_OTHER;
$dog->gender = "кобель";
$dog->name = $request->post('name');
$dog->pedigree_number = $request->post('pedigree_number');;
$dog->translit = $request->post('translit');;
$dog->birth_date = $request->post('birth_date');
$dog->color_id = $request->post('color_id');
$dog->user_added_id = Yii::$app->user->id;

if (!$dog->save()) {
    $error = $dog->getFirstErrors();
    $error = $error[array_key_first($error)];
    $is_saved = false;
} else {
    $is_saved = true;
}

?>
<?php if ($is_saved): ?>
    <?= $dog->name ?>
    <input type="hidden" id="dog-father-id" class="form-control" name="Dog[father_id]" placeholder="ID или кличка" value="<?= $dog->id ?>">
<?php else: ?>
    <input type="text" id="dog-father_id" class="form-control" name="Dog[father_id]" placeholder="ID или кличка" hx-get="/mx/dog/create/search-father" hx-trigger="keyup changed delay:500ms" hx-target="#search-results-father">
    <div id="search-results-father" class="d-flex"></div>
    <div id="self-add-father">
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#fatherModal">
            Добавить самостоятельно
        </button>
    </div>
    <div class="help-block"><?= Html::encode($error) ?></div>
<?php endif ?>