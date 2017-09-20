<?php
/**
 * Created by PhpStorm.
 * User: dungphanxuan
 * Date: 4/28/2017
 * Time: 9:40 AM
 */

namespace common\assets;

use yii\web\AssetBundle;

class PaceAsset extends AssetBundle
{
    public $sourcePath = '@bower/pace';
    public $js = [
        'pace.flot.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}