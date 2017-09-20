<?php
/**
 * Created by PhpStorm.
 * User: dungphanxuan
 * Date: 7/3/14
 * Time: 8:16 PM
 */

namespace common\assets;

use yii\web\AssetBundle;

class Mustache extends AssetBundle
{
    public $sourcePath = null;

    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
