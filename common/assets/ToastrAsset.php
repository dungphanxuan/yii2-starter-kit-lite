<?php
/**
 * Created by PhpStorm.
 * User: dungphanxuan
 * Date: 4/28/2017
 * Time: 9:41 AM
 */

namespace common\assets;

use yii\web\AssetBundle;

class ToastrAsset extends AssetBundle
{
    public $sourcePath = null;
    public $css = [
        'http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css'
    ];
    public $js = [
        'http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}