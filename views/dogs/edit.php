<?php
// views/dogs/edit.php

use yii\helpers\Html;
$this->params['action'] = 'update';

$initialPreview = [];
$initialPreviewConfig = [];

foreach ($existingPhotos as $photo) {
    $initialPreview[] = Yii::getAlias('@web/' . $photo->image_path);
    $initialPreviewConfig[] = [
        'caption' => basename($photo->image_path),
        'width' => '120px',
        'url' => \yii\helpers\Url::to(['user/dog/delete-photo']),
        'key' => $photo->id,
        'extra' => ['dog_id' => $model->id],
        'sort' => $photo->sort_order,
    ];
}

?>
<div class="dog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'photos' => $photos,
        'initialPreview' => $initialPreview,
        'initialPreviewConfig' => $initialPreviewConfig,
        'documents' => $documents,
    ]) ?>

</div>