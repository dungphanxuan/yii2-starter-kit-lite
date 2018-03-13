<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleCategory */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $categories array */
?>

<div class="article-category-form">
    <br>

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
    ]); ?>

    <?php echo $form->errorSummary($model, [
        'class'  => 'alert alert-warning alert-dismissible',
        'header' => ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Please fix the following errors</h4>'
    ]); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => 512]) ?>

    <?php echo $form->field($model, 'slug')
        ->hint(Yii::t('backend', 'If you\'ll leave this field empty, slug will be generated automatically'))
        ->textInput(['maxlength' => 1024]) ?>

    <?php echo $form->field($model, 'parent_id', [
        'template' => '{label} <div class="row"><div class="col-xs-3 col-sm-3">{input}{error}{hint}</div></div>'
    ])->dropDownList($categories, ['prompt' => 'Choose category']) ?>

    <?php echo $form->field($model, 'thumbnail')->widget(
        \trntv\filekit\widget\Upload::class,
        [
            'url'             => ['/file-storage/upload'],
            'maxFileSize'     => 5000000, // 5 MiB
            'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
        ]);
    ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>

    <hr class="b2r" style="margin-right:0;margin-left:0;">

    <div class="form-group">
        <div class="col-sm-<?= $model->isNewRecord ? '3' : '1' ?> col-xs-2"></div>
        <div class="col-sm-3 col-xs-4">
            <?php
            echo \yii\helpers\Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Back', ['index'], ['class' => 'btn btn-default btn200']);
            ?>
        </div>
        <div class="col-sm-3 col-xs-4">
            <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn200' : 'btn btn-primary btn200']) ?>
        </div>
        <div class="col-sm-3 col-xs-2">
            <?php
            if (!$model->isNewRecord) {
                echo Html::a('Delete', ['delete', 'id' => $model->id],
                    [
                        'class' => 'btn btn-warning btn200 bold',
                        'data'  => [
                            'confirm' => 'Are you sure you want to delete?',
                            'method'  => 'post',
                        ]
                    ]);
            }
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
