<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/normalize.css',
        'css/nanoscroller.css',
        'css/slick.css',
        'css/slick-theme.css',
        'css/style.css',
    ];
    public $js = [
        /*'js/jquery-3.3.1.min.js',*/
        'js/slick.min.js',
        'js/jquery.nanoscroller.min.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
