<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'site/index',
    'layout' => 'main',
    'language' => 'ru',
    'name' => 'Benganelio',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@pic' => '/images',
    ],

    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'JW-88ReA8_xGU8-LOLh8pnnwxG_njysc',
            'baseUrl' => '',
            'enableCsrfValidation' => false,
        ],
        'assetManager' => [
            'bundles' => [
                // Отключаем Bootstrap из yii\bootstrap или kartik\*
                //'yii\bootstrap5\BootstrapAsset' => true,
                //'yii\bootstrap5\BootstrapPluginAsset' => true,
                'yii\bootstrap5\BootstrapAsset' => [
                    'css' => [], // Отключаем CSS
                ],
                'yii\bootstrap5\BootstrapPluginAsset' => [
                    'js' => [], // Отключаем JS
                ],
            ],
        ],
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => ['class' => '\yii\helpers\Html'],
                    ],
                    'uses' => ['yii\bootstrap'],
                ],
                // ...
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/login'],
            'loginUrl' => ['/user/auth/login'],
            'returnUrl' => ['/user/home'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true, // true = письма пишутся в runtime/mail, false = реальные письма
            'transport' => [
                'scheme' => 'smtps',
                'host' => 'smtp.yandex.ru',
                'username' => 'your-email@yandex.ru',
                'password' => 'your-password',
                'port' => 465,
            ],
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '' => 'site/index',
                'home' => 'site/index',
                'cats' => 'cats/index',
                'cats/<id:\d+>-<translit:[\w\-]+>' => 'cats/view',
                'login' => 'user/auth/login',
                'register' => 'user/auth/register',
                'logout' => 'user/auth/logout',
                'request-password-reset' => 'user/auth/request-password-reset',
                'reset-password/<token:.+>' => 'user/auth/reset-password',
                'announcement' => 'announcement/index',
                'announcement/<animal_type:\w+>/<type:\w+>' => 'announcement/index',
                'privacy-policy' => 'site/privacy-policy',
                'terms' => 'site/terms',
                'about' => 'site/about',
                'contact' => 'site/contact',
                'help' => 'site/help',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

use yii\grid\GridView;
use yii\widgets\DetailView;

Yii::$container->set(GridView::class, [
    'tableOptions' => ['class' => 'table table-bordered  table-sm'],
    'layout' => "{items}\n{pager}",
    'pager' => [
        'class' => \yii\widgets\LinkPager::class,
        'maxButtonCount' => 5,
        'options' => ['class' => 'pagination pagination-sm justify-content-center'],
    ],
]);

Yii::$container->set(DetailView::class, [
    'options' => ['class' => 'table table-bordered table-hover'],
]);

return $config;
