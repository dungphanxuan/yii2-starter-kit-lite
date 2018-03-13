<?php
/* @var $this yii\web\View */
/* @var $dataProvider */
$this->title = Yii::t('frontend', 'Articles')
?>
<div id="article-index" class="container">
    <div class="row">
        <div class="col-md-12">
            <h1><?php echo Yii::t('frontend', 'Articles') ?></h1>
            <?php echo \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'pager'        => [
                    'hideOnSinglePage' => true,
                ],
                'itemView'     => '_item'
            ]) ?>
        </div>
    </div>
</div>