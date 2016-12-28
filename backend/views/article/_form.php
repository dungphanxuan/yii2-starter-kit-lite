<?php

use trntv\filekit\widget\Upload;
use trntv\yii\datetime\DateTimeWidget;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $categories common\models\ArticleCategory[] */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="article-form">
    <br>

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-2 col-xs-3',
                'wrapper' => 'col-sm-8 col-xs-8',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>

    <?php echo $form->errorSummary($model, [
        'class' => 'alert alert-warning alert-dismissible',
        'header' => ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Please fix the following errors</h4>'
    ]); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'slug')
        ->hint(Yii::t('backend', 'If you\'ll leave this field empty, slug will be generated automatically'))
        ->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'category_id',[
        'template' => '{label} <div class="row"><div class="col-xs-4 col-sm-4">{input}{error}{hint}</div></div>'
    ])->dropDownList(\yii\helpers\ArrayHelper::map(
            $categories,
            'id',
            'title'
        ), ['prompt'=>'']) ?>

    <?php echo $form->field($model, 'body')->widget(
        \yii\imperavi\Widget::className(),
        [
            'plugins' => ['fullscreen', 'fontcolor', 'video'],
            'options' => [
                'minHeight' => 400,
                'maxHeight' => 400,
                'buttonSource' => true,
                'convertDivs' => false,
                'removeEmptyTags' => false,
                'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
            ]
        ]
    ) ?>

    <?php echo $form->field($model, 'thumbnail')->widget(
        Upload::className(),
        [
            'url' => ['/file-storage/upload'],
            'maxFileSize' => 5000000, // 5 MiB
        ]);
    ?>

    <?php echo $form->field($model, 'attachments')->widget(
        Upload::className(),
        [
            'url' => ['/file-storage/upload'],
            'sortable' => true,
            'maxFileSize' => 10000000, // 10 MiB
            'maxNumberOfFiles' => 10
        ]);
    ?>

    <?php echo $form->field($model, 'view',[
        'template' => '{label} <div class="row"><div class="col-xs-2 col-sm-2">{input}{error}{hint}</div></div>'
    ])->textInput(['maxlength' => true]) ?>

    <div class="form-group field-article-status">
        <label class="control-label col-sm-2 col-xs-2" for="article-status"></label>
        <div class="col-sm-8 col-xs-8 fnormal">
            <?= Html::activeCheckbox($model, 'status') ?>
            <div class="help-block help-block-error "></div>
        </div>
    </div>

    <?php echo $form->field($model, 'published_at',[
        'template' => '{label} <div class="row"><div class="col-xs-3 col-sm-3">{input}{error}{hint}</div></div>'
    ])->widget(
        DateTimeWidget::className(),
        [
            'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ'
        ]
    ) ?>
    <hr>

    <div class="form-group">
        <div class="col-sm-<?=$model->isNewRecord? '3': '1'?> col-xs-2"></div>
        <div class="col-sm-3 col-xs-4">
            <?php
            echo \yii\helpers\Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Back', ['index'],['class'=>'btn btn-default btn200']);
            ?>
        </div>
        <div class="col-sm-3 col-xs-4">
            <?php echo Html::submitButton(
                $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
                ['class' => $model->isNewRecord ? 'btn btn-success btn200' : 'btn btn-primary btn200']) ?>
        </div>
        <div class="col-sm-3 col-xs-2">
            <?php
            if (!$model->isNewRecord) {
                echo Html::a('Delete', ['delete', 'id' => $model->id],
                    [
                        'class' => 'btn btn-warning btn200 bold',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete?',
                            'method' => 'post',
                        ]
                    ]);
            }
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
