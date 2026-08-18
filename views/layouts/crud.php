<?php

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
                <h4 class="text-center">
                    <h4 class="text-center">
                        Меню
                        <span>
                            <a class="btn btn-outline-danger" href="/user/home">
                                <i class="bi bi-person-circle"></i>
                            </a>
                        </span>
                    </h4>
                </h4>
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="/user/cat" class="nav-link">Кошки</a></li>
                    <li class="nav-item"><a href="/user/cat-ad" class="nav-link">Объявления по кошкам</a></li>
                    <li class="nav-item"><a href="/user/dog" class="nav-link">Собаки</a></li>
                    <li class="nav-item"><a href="/user/nursery" class="nav-link">Питомники</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Сообщения</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Настройки</a></li>
                </ul>
            </nav>
            <div class="col-12 col-lg-8 mx-auto">
                <?= $content ?>
            </div>
        </div>
    </div>
    <?= $this->render('/html/footer') ?>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>