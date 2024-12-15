<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
#        'css/site.css',
        'css/custom.css',
        'css/gallery.css',
        
    ];
    public $js = [
	    'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
#        'yii\web\JqueryAsset',
        'rmrevin\yii\fontawesome\CdnFreeAssetBundle',
        'rmrevin\yii\fontawesome\NpmFreeAssetBundle',
    ];
}
