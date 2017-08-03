<?php
/**
 * Created by PhpStorm.
 * User: dungphanxuan
 * Date: 7/3/14
 * Time: 8:16 PM
 */

namespace common\assets;

use yii\web\AssetBundle;

class Plyr extends AssetBundle {
	public $sourcePath = '@bower/plyr';

	// public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

	public $js = [
		'dist/js/plyr.js'
	];

	public $depends = [
		'yii\web\JqueryAsset'
	];
}
