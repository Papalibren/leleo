<?php

use app\models\dog;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
//extract($_POST);
$request = Yii::$app->request;

$dog = new dog();
$dog->scenario = dog::SCENARIO_OTHER;
$dog->gender = "сука";
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
    <input type="hidden" id="dog-mother-id" class="form-control" name="Dog[mother_id]" placeholder="ID или кличка" value="<?= $dog->id ?>">
<?php else: ?>
    <input type="text" id="dog-mother_id" class="form-control" name="Dog[mother_id]" placeholder="ID или кличка" hx-get="/mx/dog/create/search-mother" hx-trigger="keyup changed delay:500ms" hx-target="#search-results-mother">
    <div id="search-results-mother" class="d-flex"></div>
    <div id="self-add-mother">
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#motherModal">
            Добавить самостоятельно
        </button>
    </div>
    <div class="help-block"><?= Html::encode($error) ?></div>
<?php endif ?>