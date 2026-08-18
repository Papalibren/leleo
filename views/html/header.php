<?php

use app\models\Auth;
use yii\bootstrap5\Dropdown;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Html;
use yii\helpers\Url;

?>
<header class="header">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
            <a href="/">
                <img width="90" src="/img/logo.png" alt="">
            </a>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <!--<li class="nav-item"><a class="nav-link" href="/about">Формы</a></li>-->
                        <!--<li class="nav-item"><a class="nav-link" href="/pet">Страница животного</a></li>-->
                        <!--<li class="nav-item"><a class="nav-link" href="/admin/home">Администратор</a></li>-->

                        <!-- Объявления -->
                        <li class="nav-item dropdown mx-1">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Объявления
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="/announcement?animal_type=cats&type=sale">Кошки для продажи</a></li>
                                <li><a class="dropdown-item" href="/announcement?animal_type=cats&type=mating">Кошки для вязки</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/announcement?animal_type=dogs&type=sale">Собаки для продажи</a></li>
                                <li><a class="dropdown-item" href="/announcement?animal_type=dogs&type=mating">Собаки для вязки</a></li>
                            </ul>
                        </li>

                        <!-- Каталог -->
                        <li class="nav-item dropdown mx-1">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Каталог
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="/cats">Бенгальские кошки</a></li>
                                <li><a class="dropdown-item" href="/dogs">Собаки</a></li>
                            </ul>
                        </li>

                        <!-- Питомники -->
                        <li class="nav-item dropdown mx-1">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Питомники
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="/nursery/list">Все питомники</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/nursery/list?animal_type=cats">
                                    <i class="bi bi-arrow-right"></i> Питомники кошек
                                </a></li>
                                <li><a class="dropdown-item" href="/nursery/list?animal_type=dogs">
                                    <i class="bi bi-arrow-right"></i> Питомники собак
                                </a></li>
                            </ul>
                        </li>

                        <!-- Добавить -->
                        <li class="nav-item dropdown mx-1">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Добавить
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="/user/cat/create">Бенгальскую кошку</a></li>
                                <li><a class="dropdown-item" href="/user/dog/create">Собаку</a></li>
                            </ul>
                        </li>

                        <?php if (Yii::$app->user->isGuest): ?>
                            <!-- Гость -->
                            <li class="nav-item">
                                <a class="btn btn-outline-primary" href="<?= Url::to(['/user/auth/login']) ?>">
                                    <i class="bi bi-person-circle"></i>
                                </a>
                            </li>
                        <?php else: ?>
                            <!-- Авторизован -->
                            <?php if (Yii::$app->user->identity->isAdmin()): ?>
                                <li class="nav-item">
                                    <span class="nav-link"><a class="text-danger" href="/admin/home"><?= Html::encode(Yii::$app->user->identity->first_name) ?></a></span>
                                </li>
                                <li class="nav-item">
                                    <?= Html::beginForm(['/admin/auth/logout'], 'post', ['class' => 'form-inline']) ?>
                                    <?= Html::submitButton('Выйти', ['class' => 'btn btn-outline-danger']) ?>
                                    <?= Html::endForm() ?>
                                </li>
                            <?php endif ?>
                            <?php if (Yii::$app->user->identity->isBreeder()): ?>
                                <li class="nav-item">
                                    <span class="nav-link"><a class="text-danger" href="/user/home"><?= Html::encode(Yii::$app->user->identity->first_name) ?></a></span>
                                </li>
                                <li class="nav-item">
                                    <?= Html::beginForm(['/user/auth/logout'], 'post', ['class' => 'form-inline']) ?>
                                    <?= Html::submitButton('Выйти', ['class' => 'btn btn-outline-danger']) ?>
                                    <?= Html::endForm() ?>
                                </li>
                            <?php endif ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>