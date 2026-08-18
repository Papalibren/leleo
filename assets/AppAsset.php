<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;


class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.css',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap',
        'css/theme.css',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css'
    ];
    public $js = [
        'js/bs.js',
        'https://unpkg.com/htmx.org@2.0.4',
        'js/theme.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
