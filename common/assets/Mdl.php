<?php
/**
 * Created by PhpStorm.
 * User: dungphanxuan
 * Date: 8/2/14
 * Time: 11:40 AM
 */

namespace common\assets;

use yii\web\AssetBundle;

/*
 *  Material Design Lite Assets
 * */

class Mdl extends AssetBundle
{
    //public $sourcePath = '@bower/material-design-lite/dist';
    public $sourcePath = null;
    public $js = [
        'https://code.getmdl.io/1.3.0/material.min.js'
    ];
    public $css = [
        'https://fonts.googleapis.com/icon?family=Material+Icons',
        'https://code.getmdl.io/1.3.0/material.indigo-pink.min.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
