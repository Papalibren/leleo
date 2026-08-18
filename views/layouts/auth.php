<?php

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column justify-content-between min-vh-100">
        <?php $this->beginBody() ?>
        <?= $this->render('/html/header') ?>
        <?= Alert::widget() ?>
        <main class="flex-grow-1">
            <?= $content ?>
        </main>
        <?= $this->render('/html/footer') ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>