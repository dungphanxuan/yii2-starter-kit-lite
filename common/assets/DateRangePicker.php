<?php
/**
 * Created by PhpStorm.
 * User: dungphanxuan
 * Date: 7/3/14
 * Time: 8:16 PM
 */

namespace common\assets;

use yii\web\AssetBundle;

class DateRangePicker extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-daterangepicker';
    public $csss = [
        'daterangepicker.css'
    ];
    public $js = [
        'daterangepicker.js'
    ];

    public $depends = [
        'common\assets\Moment',
        'yii\web\JqueryAsset'
    ];
}
