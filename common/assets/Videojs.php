<?php
/**
 * Created by PhpStorm.
 * User: dungphanxuan
 * Date: 7/3/14
 * Time: 8:16 PM
 */

namespace common\assets;

use yii\web\AssetBundle;

class Videojs extends AssetBundle
{
    public $sourcePath = '@bower/videojs';
    public $css = [
        'buid/css/video-js.css'
    ];

    public $js = [
        'build/js/video.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
