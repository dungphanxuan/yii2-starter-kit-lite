<?php
/**
 * Created by PhpStorm.
 * User: dungphanxuan
 * Date: 7/3/14
 * Time: 8:16 PM
 */

namespace common\assets;

use yii\web\AssetBundle;
use yii\web\View;

class Moment extends AssetBundle
{
    public $sourcePath = '@bower/moment';

    public $jsOptions = ['position' => View::POS_HEAD];
    public $js = [
        'moment.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
