<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $categories */

/* @var $this yii\web\View */
/* @var $model backend\models\search\ArticleSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="article-search box-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'layout' => 'horizontal'
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'id')->textInput() ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'title')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?php
            echo $form->field($model, 'category_id')->widget(Select2::classname(), [
                'data' =>  ArrayHelper::map(
                    $categories,
                    'id',
                    'title'
                ),
                'options' => ['placeholder' => 'Chọn danh mục ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>

        <div class="col-sm-6">
            <?php
            echo $form->field($model, 'status')->dropDownList(
                [1 => 'Xuất bản', 0 => 'Chưa xuất bản'],
                ['prompt' => 'Chọn trạng thái...']
            )->label('Trạng thái')
            ?>
        </div>
    </div>

    <div class="row mt10">
        <div class="col-md-6 col-sm-6 col-xs-12">
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
