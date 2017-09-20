<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ArticlePickup */
/* @var $articles */

$this->title = 'Create Article Pickup';
$this->params['breadcrumbs'][] = ['label' => 'Article Pickups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-pickup-create">

    <?php echo $this->render('_form', [
        'model'    => $model,
        'articles' => $articles,
    ]) ?>

</div>
