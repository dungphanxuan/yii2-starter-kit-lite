<?php

use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
    ]); ?>
        <?php echo $form->field($model, 'username') ?>
        <?php echo $form->field($model, 'email') ?>
        <?php echo $form->field($model, 'password')->passwordInput() ?>
        <?php echo $form->field($model, 'status')->dropDownList(User::statuses()) ?>
        <?php echo $form->field($model, 'roles')->checkboxList($roles) ?>
        <div class="form-group">
            <div class="col-sm-<?=$model->username? '3': '2'?> col-xs-2"></div>
            <div class="col-sm-3 col-xs-4">
                <?php
                echo \yii\helpers\Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Back', ['user/index'],['class'=>'btn btn-default btn200']);
                ?>
            </div>
            <div class="col-sm-3 col-xs-4">
                <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary btn200', 'name' => 'signup-button']) ?>
            </div>
            <div class="col-sm-3 col-xs-2">
                <?php
                if ($model->username) {
                    echo Html::a('Delete', ['/user/delete', 'id' => $model->username],
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
