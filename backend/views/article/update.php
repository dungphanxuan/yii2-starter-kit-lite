<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $categories */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
        'modelClass' => 'Article',
    ]) . ' ' . StringHelper::truncateWords($model->title, 12);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="article-update">

    <?php echo $this->render('_form', [
        'model'      => $model,
        'categories' => $categories,
    ]) ?>

</div>
