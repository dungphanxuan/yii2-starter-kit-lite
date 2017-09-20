<?php

use backend\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArticlePickupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Article Pickups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-pickup-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('Create Article Pickup', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            [
                'class'          => 'yii\grid\CheckboxColumn',
                'headerOptions'  => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'width:7%;text-align:center'],
            ],

            [
                'attribute'      => 'id',
                'format'         => 'raw',
                'headerOptions'  => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'width:10%;text-align:center'],
            ],
            [
                'attribute' => 'article_id',
                'format'    => 'raw',
                'value'     => function ($model) {
                    return Html::a($model->article ? $model->article->title : '', [
                        'update',
                        'id' => $model->id
                    ], ['class' => 'alink']);

                },
                'filter'    => ArrayHelper::map(\common\models\Article::find()->all(), 'id', 'title')
            ],
            [
                'attribute'      => 'sort_number',
                'format'         => 'raw',
                'headerOptions'  => ['style' => 'text-align:center'],
                'contentOptions' => ['style' => 'width:10%;text-align:center'],
            ],
            [
                'class'          => 'backend\grid\ActionColumn',
                'template'       => '{update} {delete}',
                'contentOptions' => ['style' => 'width:10%;text-align:center'],
            ],
        ],
    ]); ?>

</div>
