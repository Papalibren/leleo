<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\User[] $recentUsers */

$this->title = 'Меню управления администратора'
?>
<main class="col-md-9 col-lg-10 content">
    <h2>Личный кабинет администратора</h2>
    <p>Управляйте пользователями, животными и объявлениями.</p>

    <?php if (!empty($recentUsers)): ?>
        <div class="alert alert-info">
            <strong><i class="bi bi-bell"></i> Новые регистрации за последние 7 дней: <?= count($recentUsers) ?></strong>
            <ul class="mb-0 mt-2">
                <?php foreach ($recentUsers as $user): ?>
                    <li>
                        <?= Html::a(Html::encode($user->gfn() . ' (' . $user->email . ')'), Url::to(['/admin/user/view', 'id' => $user->id])) ?>
                        — <?= Html::encode($user->created_at) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <div class="alert alert-secondary">За последние 7 дней новых регистраций нет.</div>
    <?php endif; ?>
</main>