<?php
use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var \app\models\Cat[] $siblings */
?>

<div class="row">
    <?php foreach ($siblings as $sibling): ?>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card h-100 text-center">
                <?= Html::a(
                    Html::img('/' . $sibling->getFirstPhoto()->image_path, [
                        'class' => 'card-img-top img-fluid',
                        'alt' => $sibling->name,
                        'style' => 'max-height:200px; object-fit:cover;'
                    ]),
                    ['cats/view', 'id' => $sibling->id, 'translit' => $sibling->translit]
                ) ?>
                <div class="card-body">
                    <h6 class="card-title">
                        <?= Html::a(Html::encode($sibling->name), ['cats/view', 'id' => $sibling->id]) ?>
                        <span><?= $sibling->gender == 'кошка' ? '♀️' : '♂️' ?></span>
                    </h6>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>