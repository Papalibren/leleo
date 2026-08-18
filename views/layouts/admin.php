<?php
// views/layouts/admin.php

use app\assets\AppAsset;
use app\models\Auth;
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
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <h4 class="text-center">Меню</h4>
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="/admin/user" class="nav-link">Заводчики</a></li>
                    <li class="nav-item"><a href="/admin/cat" class="nav-link">Кошки</a></li>
                    <li class="nav-item"><a href="/admin/dog" class="nav-link">Собаки</a></li>
                    <li class="nav-item"><a href="/admin/ads" class="nav-link">Объявления</a></li>
                    <li class="nav-item"><a href="/admin/cat-moderation/index" class="nav-link">Объявления</a></li>
                </ul>
            </nav>
            <div class="col-12 col-lg-10 p-3">
                <?= $content ?>
            </div>
        </div>
    </div>
    <?= $this->render('/html/footer') ?>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>