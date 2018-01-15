<?php

use backend\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel \backend\modules\system\models\search\KeyStorageItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Key Storage Items');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="key-storage-item-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="pull-right">
            <p>
                <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
                    'modelClass' => 'Key Storage Item',
                ]), ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'     => 'key',
                    'format'        => 'raw',
                    'headerOptions' => ['style' => 'text-align:center'],
                    'value'         => function ($model) {
                        return Html::a($model->key, ['update', 'id' => $model->key], ['class' => 'alink']);
                    },
                ],
                'value',

                [
                    'class'    => 'backend\grid\ActionColumn',
                    'template' => '{update} {delete}'
                ],
            ],
        ]); ?>

    </div>


<?php
$app_css = <<<CSS
.table-striped>tbody>tr:nth-of-type(odd) {
    background-color: #CFD8DC !important;
}
CSS;

$this->registerCss($app_css);