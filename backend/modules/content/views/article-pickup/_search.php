<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ArticlePickupSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="article-pickup-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'article_id') ?>

    <?php echo $form->field($model, 'sort_number') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', [
            'class' =>
                'btn btn-primary'
        ]) ?>
        <?php echo Html::resetButton('Reset', [
            'class' =>
                'btn btn-default'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
