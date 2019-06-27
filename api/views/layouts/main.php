<?php
/* @var $this \yii\web\View */

use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* @var $content string */

$this->beginContent('@api/views/layouts/base.php')
?>
    <div class="container">

        <?php echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?php if (Yii::$app->session->hasFlash('alert')): ?>
            <?php echo \yii\bootstrap\Alert::widget([
                'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
            ]) ?>
        <?php endif; ?>

        <?php echo $content ?>

    </div>
<?php $this->endContent() ?>