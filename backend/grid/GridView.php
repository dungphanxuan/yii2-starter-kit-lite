<?php
/**
 * Created by PhpStorm.
 * User: Adnet
 * Date: 1/5/2017
 * Time: 3:30 PM
 */

namespace backend\grid;


class GridView extends \yii\grid\GridView
{
    public $tableOptions = [
        'class' => 'table table-striped table-bordered table-hover'
    ];

    public $pager = [
        'linkOptions' => ['class' => 'page-link'],
        'pageCssClass' => 'page-item',
        'activePageCssClass' => 'page-item active',
        'disabledPageCssClass' => 'page-item disabled',
        'disabledListItemSubTagOptions' => [
            'tag' => 'a'
        ]
    ];

    public $layout = '{items}<br><div class="row"><div class="col-xs-12 col-md-5"><div class="spagination">{summary}</div></div><div class="col-xs-12 col-md-7"><div class="spager"> {pager}</div></div></div>';

}