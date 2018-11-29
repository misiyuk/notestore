<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Slider asset bundle.
 */
class AudioPlayerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/audioplayer.js',
    ];
    public $css = [
    ];
}
