<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Article Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="pull-right">
        <p>
            <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
                'modelClass' => 'Article Category',
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
