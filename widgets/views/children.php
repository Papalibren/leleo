<?php
use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var \app\models\Cat[] $children */
?>

<div class="row">
    <?php foreach ($children as $child): ?>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card h-100 text-center">
                <?= Html::a(
                    Html::img('/' . $child->getFirstPhoto()->image_path, [
                        'class' => 'card-img-top img-fluid',
                        'alt' => $child->name,
                        'style' => 'max-height:200px; object-fit:cover;'
                    ]),
                    ['cats/view', 'id' => $child->id, 'translit' => $child->translit]
                ) ?>
                <div class="card-body">
                    <h6 class="card-title">
                        <?= Html::a(Html::encode($child->name), ['cats/view', 'id' => $child->id]) ?>
                        <span><?= $child->gender == 'кошка' ? '♀️' : '♂️' ?></span>
                    </h6>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>