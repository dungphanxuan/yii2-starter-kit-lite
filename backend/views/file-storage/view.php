<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\FileStorageItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'File Storage Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-storage-item-view">

    <div class="pull-right">
        <p>
            <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'component',
            [
                'attribute' => 'base_url',
                'format' => 'url',
                'label' => 'Full Url',
                'value' => $model->base_url . '/' . $model->path
            ],
            'base_url:url',
            'path',
            'type',
            'size',
            'name',
            'upload_ip',
            'created_at:datetime',
        ],
    ]) ?>

</div>
