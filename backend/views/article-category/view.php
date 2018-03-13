<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleCategory */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Article Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), [
            'update',
            'id' => $model->id
        ], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'slug',
            'title',
            'parent.title',
            'status',
        ],
    ]) ?>

    <div class="row">
        <div class="col-md-12">
            <h4>Danh mục con: <?= $model->title ?></h4>
        </div>
        <div class="col-md-12">
            <?php echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'options'      => [
                    'class' => 'grid-view table-responsive'
                ],
                'pager'        => [
                    'maxButtonCount' => 15,
                ],
                'columns'      => [
                    ['class' => 'yii\grid\CheckboxColumn'],

                    [
                        'attribute'      => 'id',
                        'format'         => 'raw',
                        'headerOptions'  => ['style' => 'text-align:center'],
                        'contentOptions' => ['style' => 'width:10%;text-align:center'],
                    ],
                    'title',
                    'slug',

                    [
                        'class'     => \common\grid\EnumColumn::class,
                        'attribute' => 'status',
                        'enum'      => [
                            Yii::t('backend', 'Not Published'),
                            Yii::t('backend', 'Published')
                        ]
                    ],

                    [
                        'class'    => 'backend\grid\ActionColumn',
                        'template' => '{update} {delete}'
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>
