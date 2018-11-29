<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class FancyBoxAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/jquery.fancybox.js',
    ];
    public $css = [
        'css/jquery.fancybox.css',
    ];
}
