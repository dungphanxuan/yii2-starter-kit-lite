<?php
/**
 * Created by PhpStorm.
 * User: dungphanxuan
 * Date: 6/7/2017
 * Time: 10:54 AM
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\ArticleCategory */
?>
<tr id="item<?= $model->id ?>" class="item" data-id="<?= $model->id ?>">
    <td width="5%"><?= $model->id ?></td>
    <td><p class="lead1"><?= $model->title ?></p></td>
    <td><p><?= $model->slug ?></p></td>
    <td width="9%" style="text-align: center"><strong><?= $model->order ?></strong></td>
    <td style="text-align: center">
        <a href="<?= \yii\helpers\Url::to(['/article/index', 'category_id' => $model->id]) ?>">
            <?= $model->getTotal() ?>
        </a>
    </td>

    <td>
        <?php
        $options = [
            'class' => ($model->status == 1) ? 'glyphicon glyphicon-ok text-success' : 'glyphicon glyphicon-remove text-danger',
        ];
        echo Html::tag('p', Html::tag('span', '', $options), ['class' => 'text-center']);

        ?>
    </td>

    <td style="width: 5%"><?= Html::a('Xem', ['view', 'id' => $model->id, 'parent_id' => $model->id], [
            'class'     => 'btn btn-flat btn-primary btn-sm',
            'data-pjax' => 0
        ]) ?>
    </td>

    <td style="width: 5%"><?= Html::a('Cập nhật', ['update', 'id' => $model->id], [
            'class'     => 'btn btn-flat btn-info btn-sm',
            'data-pjax' => 0
        ]) ?>
    </td>

    <td style="width: 5%"><?= Html::a('Xóa', ['delete', 'id' => $model->id], [
            'class'     => 'btn btn-flat btn-warning  btn-sm',
            'data'      => [
                'confirm' => 'Xác nhận xóa',
                'method'  => 'post',
            ],
            'data-pjax' => 0
        ]) ?>
    </td>

</tr>