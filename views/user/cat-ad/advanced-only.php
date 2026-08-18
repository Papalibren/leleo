<?php
// views/user/cat-ad/advanced-only.php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Доступ только для продвинутых пользователей';
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-warning">
                <div class="card-header bg-warning text-white text-center py-2">
                    <h5 class="mb-0"><?= Html::encode($this->title) ?></h5>
                </div>
                <div class="card-body text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-crown fa-3x text-warning"></i>
                    </div>

                    <p class="text-muted mb-4">
                        <?= Html::encode($message) ?>
                        Для получения доступа к расширенным возможностям сайта
                        необходимо приобрести продвинутый аккаунт.
                    </p>

                    <div class="d-grid">
                        <?= Html::a(
                            'Вернуться в личный кабинет',
                            ['/user/home'],
                            ['class' => 'btn btn-secondary']
                        ) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>