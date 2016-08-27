<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetCarouselItem */

$this->title = Yii::t('admin', 'Update {modelClass}: ', [
    'modelClass' => 'Widget Carousel Item',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Widget Carousel Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->carousel->key, 'url' => ['update', 'id' => $model->carousel->id]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="widget-carousel-item-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
