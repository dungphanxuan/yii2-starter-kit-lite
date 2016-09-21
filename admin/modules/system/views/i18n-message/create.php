<?php
/* @var $this yii\web\View */
/* @var $model admin\modules\i18n\models\I18nMessage */

$this->title = Yii::t('admin', 'Create {modelClass}', [
    'modelClass' => 'I18n Message',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'I18n Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="i18n-message-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
