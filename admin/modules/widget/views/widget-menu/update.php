<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetMenu */

$this->title = Yii::t('admin', 'Update {modelClass}: ', [
    'modelClass' => 'Widget Menu',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Widget Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="widget-menu-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
