<?php
use app\widgets\charts\Pie;
use app\widgets\Test;
use yii\bootstrap5\Nav;

$this->title = 'Графики';
?>

<div class="container">
    <div class="row">
        <div class="col-12 col-lg-8">
            <code class="language-css">
                p { color: red }
            </code>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
        <div id="chart_div"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-7">
            <?php Test::begin(['tag' => 'code', 'options' => ['class' => 'bg-dark']])?>
            YAYTSA
            <?php Test::end()?>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-4">
            <?=Nav::widget([
                'options' => ['class' =>'nav-pills'],
                'items' => [
                    ['label' => 'FIRST',
                    'url' => '/',
                    'options' => ['class' => 'fw-bold'],
                    'linkOptions' => ['class' => 'text-success'],
                    'active' => True,
                    ],
                    [
                        'label' => 'DROP',
                        'items' => [
                            ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
                            '<div class="dropdown-divider"></div>',
                            ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
                        ]
                    ]
                ]
            ])?>
        </div>
    </div>
</div>

<?=Pie::widget()?>