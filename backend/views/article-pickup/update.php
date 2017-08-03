<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ArticlePickup */
/* @var $articles */

$this->title                   = 'Update Article Pickup: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = [ 'label' => 'Article Pickups', 'url' => [ 'index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $model->id, 'url' => [ 'view', 'id' => $model->id ] ];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-pickup-update">

	<?php echo $this->render( '_form', [
		'model'    => $model,
		'articles' => $articles,
	] ) ?>

</div>
