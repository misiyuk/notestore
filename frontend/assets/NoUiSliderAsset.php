<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Slider asset bundle.
 */
class NoUiSliderAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/nouislider.min.js',
    ];
    public $css = [
        'css/nouislider.min.css',
    ];
}
