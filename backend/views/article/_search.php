<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

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
        <div class="col-md-6 col-sm-6 col-xs-12">
            <span class="col-md-4 col-sm-4 col-xs-4" style=""><?=$model->getAttributeLabel('id')?></span>
            <div class="col-md-8 col-sm-8 col-xs-8">
                <?=Html::activeTextInput($model, 'id', ['class'=>'form-control'])?>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 spm10">
            <span class="col-md-4 col-sm-4 col-xs-4" style=""><?=$model->getAttributeLabel('title')?></span>
            <div class="col-md-8 col-sm-8 col-xs-8">
                <?=Html::activeTextInput($model, 'title', ['class'=>'form-control'])?>
            </div>
        </div>
    </div>

    <div class="row mt10">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <span class="col-md-4 col-sm-4 col-xs-4" style=""><?=$model->getAttributeLabel('category_id')?></span>
            <div class="col-md-8 col-sm-8 col-xs-8">
                <?=Html::activeDropDownList($model, 'category_id', \yii\helpers\ArrayHelper::map(
                    $categories,
                    'id',
                    'title'
                ), ['class'=>'form-control', 'prompt' =>'Select...'])?>

            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 spm10">
            <span class="col-md-4 col-sm-4 col-xs-4" style=""><?=$model->getAttributeLabel('slug')?></span>
            <div class="col-md-8 col-sm-8 col-xs-8">
                <?=Html::activeTextInput($model, 'slug', ['class'=>'form-control'])?>
            </div>
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
