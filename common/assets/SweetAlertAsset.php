<?php
/**
 * Created by PhpStorm.
 * User: dungphanxuan
 * Date: 4/28/2017
 * Time: 9:40 AM
 */

namespace common\assets;

namespace common\assets;

use yii\web\AssetBundle;

class SweetAlertAsset extends AssetBundle
{
    public $sourcePath = null;
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css'
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}