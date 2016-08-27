<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetText */

$this->title = Yii::t('admin', 'Update {modelClass}: ', [
    'modelClass' => 'Text Block',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Text Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="text-block-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
