<?php

namespace app\widgets\calendar;

use yii\web\AssetBundle;


class CalendarAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        ['https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js', 'position' => \yii\web\View::POS_HEAD],
    ];

    public $depends = [

    ];
}
