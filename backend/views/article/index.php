<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <div class="pull-right">
        <p>
            <?php echo Html::a(
                Yii::t('backend', 'Create {modelClass}', ['modelClass' => 'Article']),
                ['create'],
                ['class' => 'btn btn-success']) ?>
            <button class="btn btn-danger btnDelete">Delete</button>

        </p>

    </div>
    <div class="clearfix"></div>
    <?php echo $this->render('_search', ['model' => $searchModel, 'categories' => $categories]); ?>
    <br>
    <br>
    <?php Pjax::begin(['id' => 'datas', 'timeout' => 3000]); ?>
      <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-hover'
        ],
        'options' => ['id' => 'w1'],
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
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
            [
                'attribute'=>'category_id',
                'value'=>function ($model) {
                    return $model->category ? $model->category->title : null;
                },
                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\ArticleCategory::find()->all(), 'id', 'title')
            ],
            [
                'attribute'=>'author_id',
                'value'=>function ($model) {
                    return $model->author->username;
                }
            ],

            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => [1 =>  Yii::t('backend', 'Published'), 0 => Yii::t('backend', 'Not Published')],
                'value'=>function ($model) {
                    $options = [
                        'class' => ($model->status ==1)? 'glyphicon glyphicon-ok text-success' :'glyphicon glyphicon-remove text-danger',
                    ];
                    return Html::tag('p',Html::tag('span','',$options),['class'=>'text-center']);
                },
                'contentOptions' => ['style' => 'width:10%;text-align:center'],
            ],
            'published_at:date',
            //'created_at:datetime',
            // 'updated_at',

            [
                'class' => 'backend\grid\ActionColumn',
                'template'=>'{update} {copy} {delete}',
                'buttons' => [
                    'copy' => function ($url, $model, $key) {
                        $url = Url::to(['/article/create', 'type'=>'copy', 'id' => $key]);
                        return Html::a('<span class="glyphicon glyphicon-copy"></span>', $url, [
                            'title' => \Yii::t('common', 'Copy'),
                            'class' => 'btnaction btn btn-success btn-xs'
                        ]);
                    },
                ]
            ]
        ]
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
$ajaxUrl = Url::to(['ajax-delete']);
$app_js = <<<JS
$(".btnDelete").click(function(){
    var keys = $('#w1').yiiGridView('getSelectedRows');
    if(keys.length > 0){
        bootbox.confirm({
        message: "Are you sure you want to delete?",
        buttons: {
            confirm: {
                label: 'Ok',
                className: 'btn-success'
            },
            cancel: {
                label: 'Cancel',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result){
               var keys = $('#w1').yiiGridView('getSelectedRows');
               $.ajax({
                  url: '$ajaxUrl',
                  data: {
                     ids: keys
                  },
                  error: function() {
                     alert('An error occurred');
                  },
                  success: function(data) {
                     $.pjax.reload({container:"#datas"}); 
                  },
                  type: 'POST'
               });
             }
            }
        });     
    }else{
        bootbox.alert("No item!");
    }
});
JS;
$this->registerJs($app_js);

