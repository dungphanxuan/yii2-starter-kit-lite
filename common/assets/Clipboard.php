<?php
/**
 * Created by PhpStorm.
 * User: dungphanxuan
 * Date: 7/3/14
 * Time: 8:16 PM
 */

namespace common\assets;

use yii\web\AssetBundle;

class Clipboard extends AssetBundle
{
    public $sourcePath = '@bower/flot';
    public $js = [
        'js/clipboard.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
