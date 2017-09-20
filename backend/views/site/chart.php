<?php

use kartik\daterange\DateRangePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dateRange string */
/* @var $arrLabel array */
/* @var $arrDataset array */

$this->title = 'ChartJS';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="file-storage-item-index">

        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">ChartJs</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <?php
                                $form = ActiveForm::begin([
                                    'id'     => 'stats_form',
                                    'action' => Url::to(['']),
                                    'method' => 'get',
                                ])
                                ?>

                                <?php
                                $addon = <<< HTML
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                        </span>
HTML;
                                echo '<label class="control-label">Date Range</label>';
                                echo '<div class="input-group drp-container">';
                                echo DateRangePicker::widget([
                                        'name'           => 'date_range_1',
                                        'value'          => $dateRange,
                                        'useWithAddon'   => true,
                                        'presetDropdown' => true,
                                        'options'        => [
                                            'id'    => 'date-range1',
                                            'class' => 'form-control'
                                        ],
                                        'pluginOptions'  => [
                                            'locale' => [
                                                'format'    => 'YYYY-MM-DD',
                                                'separator' => '-',
                                            ],
                                            'opens'  => 'left'
                                        ]
                                    ]) . $addon;
                                echo '</div>';

                                ?>
                                <?php ActiveForm::end() ?>
                            </div>
                        </div>
                        <?= \dosamigos\chartjs\ChartJs::widget([
                            'type'    => 'line',
                            'options' => [
                                'height' => 150,
                                'width'  => 400
                            ],
                            'data'    => [
                                'labels'   => $arrLabel,
                                'datasets' => $arrDataset
                            ]
                        ]);
                        ?>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="button" class="btn btn-info pull-right">More Info</button>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>

        </div>

    </div>

<?php
$app_css = <<<CSS

CSS;


$app_js = <<<JS

 $('#date-range1').change(function () {
    $('form#stats_form').submit();
});
JS;
$this->registerJs($app_js);
