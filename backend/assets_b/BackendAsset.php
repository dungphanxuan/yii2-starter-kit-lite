<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:14 PM
 */

namespace backend\assets_b;

use yii\web\AssetBundle;

class BackendAsset extends AssetBundle {
	public $basePath = '@webroot';
	public $baseUrl = '@web/web';

	public $css = [
		'css/style.css'
	];
	public $js = [
		'js/app.js',
		'https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js',
		'js/libs/confirm.js',
	];

	public $depends = [
		'yii\web\YiiAsset',
		'common\assets\AdminLte',
		'common\assets\Html5shiv'
	];
}
