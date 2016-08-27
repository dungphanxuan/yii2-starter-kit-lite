<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model admin\models\SystemLog */

$this->title = Yii::t('admin', 'Error #{id}', ['id'=>$model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'System Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-log-view">

    <p>
        <?php echo Html::a(Yii::t('admin', 'Delete'), ['delete', 'id'=>$model->id], ['class' => 'btn btn-danger', 'data'=>['method'=>'post']]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'level',
            'category',
            [
                'attribute' => 'log_time',
                'format' => 'datetime',
                'value' => (int) $model->log_time
            ],
            'prefix:ntext',
            [
                'attribute'=>'message',
                'format'=>'raw',
                'value'=>Html::tag('pre', $model->message, ['style'=>'white-space: pre-wrap'])
            ],
        ],
    ]) ?>

</div>
