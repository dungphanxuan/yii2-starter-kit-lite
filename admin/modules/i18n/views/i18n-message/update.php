<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model admin\modules\i18n\models\I18nMessage */

$this->title = Yii::t('admin', 'Update {modelClass}: ', [
    'modelClass' => 'I18n Message',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'I18n Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'language' => $model->language]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="i18n-message-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
