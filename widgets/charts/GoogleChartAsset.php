<?php

namespace app\widgets\charts;

use yii\web\AssetBundle;


class GoogleChartAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        ['https://www.gstatic.com/charts/loader.js', 'position' => \yii\web\View::POS_HEAD],
    ];

    public $depends = [

    ];
}
