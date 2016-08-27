<?php
/* @var $this yii\web\View */
/* @var $model common\models\WidgetMenu */

$this->title = Yii::t('admin', 'Create {modelClass}', [
    'modelClass' => 'Widget Menu',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Widget Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-menu-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
