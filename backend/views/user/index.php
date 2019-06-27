<?php

use backend\grid\GridView;
use common\grid\EnumColumn;
use common\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="user-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="pull-right">
            <p>
                <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
                    'modelClass' => 'User',
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
                    'class' => 'yii\grid\CheckboxColumn',
                    'headerOptions' => ['style' => 'width:3%;text-align:center'],
                    'contentOptions' => ['style' => 'width:3%;text-align:center'],
                    'checkboxOptions' => [
                        'class' => 'select-item'
                    ]
                ],
                [
                    'attribute' => 'id',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'text-align:center'],
                    'contentOptions' => ['style' => 'width:10%;text-align:center'],
                ],
                [
                    'attribute' => 'username',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'text-align:center'],
                    'value' => function ($model) {
                        return Html::a($model->username, ['update', 'id' => $model->id], ['class' => 'alink']);
                    },
                ],
                'email:email',
                [
                    'class' => EnumColumn::class,
                    'attribute' => 'status',
                    'enum' => User::statuses(),
                    'filter' => User::statuses()
                ],
                'created_at:datetime',
                //'logged_at:datetime',
                // 'updated_at',

                ['class' => 'backend\grid\ActionColumn'],
            ],
        ]); ?>

    </div>


<?php
$app_css = <<<CSS
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #CFD8DC !important;
}

.is-selected {
    background-color: #e0e0e0 !important;
}

input[type='checkbox'] {
    cursor: pointer;
}
CSS;

$this->registerCss($app_css);

$app_js = <<<JS
$(document).on("change", ".select-item", function () {
    if ($(this).is(":checked")) {
        $(this).parents("tr").addClass("is-selected");
    } else {
        $(this).parents("tr").removeClass("is-selected");
    }
});
JS;

$this->registerJs($app_js);