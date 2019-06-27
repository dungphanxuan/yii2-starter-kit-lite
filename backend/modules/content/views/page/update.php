<?php

/**
 * @var $this  yii\web\View
 * @var $model common\models\Page
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
        'modelClass' => 'Page',
    ]) . ' ' . $model->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');

?>

<?php echo $this->render('_form', [
    'model' => $model,
]) ?>
