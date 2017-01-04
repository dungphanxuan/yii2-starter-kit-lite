<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \backend\models\search\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="pull-right">
        <p>
            <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
               'modelClass' => 'Page',
              ]), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
    <div class="clearfix"></div>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-hover'
        ],
        'columns' => [

            [
                'attribute' => 'id',
                'format' => 'raw',
                'headerOptions' => ['style'=>'text-align:center'],
                'contentOptions' => ['style' => 'width:10%;text-align:center'],
            ],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'headerOptions' => ['style'=>'text-align:center'],
                'value' => function ($model) {
                    return Html::a($model->title, ['update', 'id' =>$model->id], ['class' =>'alink']);
                },
            ],
            'slug',
            'status',

            [
                'class' => 'backend\grid\ActionColumn',
                'template'=>'{update} {delete}'
            ],
        ],
    ]); ?>

</div>
