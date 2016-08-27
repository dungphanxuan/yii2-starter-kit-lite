<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \admin\models\search\WidgetTextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Text Blocks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-block-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('admin', 'Create {modelClass}', [
            'modelClass' => 'Text Block',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'key',
            'title',
            [
                'class'=>\common\grid\EnumColumn::className(),
                'attribute'=>'status',
                'enum'=>[
                    Yii::t('admin', 'Disabled'),
                    Yii::t('admin', 'Enabled')
                ],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}'
            ],
        ],
    ]); ?>

</div>
