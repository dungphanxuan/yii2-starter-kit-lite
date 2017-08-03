<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ArticlePickup */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $articles */
?>

<div class="article-pickup-form">

	<?php $form = ActiveForm::begin( [
		'layout' => 'horizontal',
	] ); ?>

	<?php echo $form->errorSummary( $model, [
		'class'  => 'alert alert-warning alert-dismissible',
		'header' => ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Please fix the following errors</h4>'
	] ); ?>

	<?php echo $form->field( $model, 'article_id', [
	] )->dropDownList( \yii\helpers\ArrayHelper::map(
		$articles,
		'id',
		'title'
	), [ 'prompt' => '' ] ) ?>

	<?php echo $form->field( $model, 'sort_number' )->textInput() ?>

    <hr>

    <div class="form-group">
        <div class="col-sm-<?= $model->isNewRecord ? '3' : '1' ?> col-xs-2"></div>
        <div class="col-sm-3 col-xs-4">
			<?php
			echo \yii\helpers\Html::a( '<span class="glyphicon glyphicon-arrow-left"></span>' . Yii::t( 'backend', 'Back' ),
				[ 'index' ], [ 'class' => 'btn btn-default btn200' ] );
			?>
        </div>
        <div class="col-sm-3 col-xs-4">
			<?php echo Html::submitButton( $model->isNewRecord ? Yii::t( 'backend', 'Create' ) :
				Yii::t( 'backend', 'Update' ), [
				'class' => $model->isNewRecord ? 'btn btn-success btn200' : 'btn btn-primary
            btn200'
			] ) ?>
        </div>
        <div class="col-sm-3 col-xs-2">
			<?php
			if ( ! $model->isNewRecord ) {
				echo Html::a( Yii::t( 'backend', 'Delete' ), [ 'delete', 'id' => $model->id ],
					[
						'class' => 'btn btn-warning btn200 bold',
						'data'  => [
							'confirm' => 'Are you sure you want to delete?',
							'method'  => 'post',
						]
					] );
			}
			?>
        </div>
    </div>

	<?php ActiveForm::end(); ?>

</div>
