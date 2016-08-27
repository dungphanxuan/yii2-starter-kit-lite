<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 * @var $this \yii\web\View
 * @var $provider \probe\provider\ProviderInterface
 */
use common\models\FileStorageItem;
use common\models\User;

$this->title = Yii::t('admin', 'System Information');
$this->registerJs("window.paceOptions = { ajax: false }", \yii\web\View::POS_HEAD);
$this->registerJsFile(
    Yii::$app->request->baseUrl . 'js/system-information/index.js',
    ['depends' => ['\yii\web\JqueryAsset', '\common\assets\Flot', '\yii\bootstrap\BootstrapPluginAsset']]
) ?>
<div id="system-information-index">
    <div class="row connectedSortable">
        <div class="col-lg-6 col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-hdd-o"></i>
                    <h3 class="box-title"><?php echo Yii::t('admin', 'Processor') ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt><?php echo Yii::t('admin', 'Processor') ?></dt>
                        <dd><?php echo $provider->getCpuModel() ?></dd>

                        <dt><?php echo Yii::t('admin', 'Processor Architecture') ?></dt>
                        <dd><?php echo $provider->getArchitecture() ?></dd>

                        <dt><?php echo Yii::t('admin', 'Number of cores') ?></dt>
                        <dd><?php echo $provider->getCpuCores() ?></dd>
                    </dl>
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-hdd-o"></i>
                    <h3 class="box-title"><?php echo Yii::t('admin', 'Operating System') ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt><?php echo Yii::t('admin', 'OS') ?></dt>
                        <dd><?php echo $provider->getOsType() ?></dd>

                        <dt><?php echo Yii::t('admin', 'OS Release') ?></dt>
                        <dd><?php echo $provider->getOsRelease() ?></dd>

                        <dt><?php echo Yii::t('admin', 'Kernel version') ?></dt>
                        <dd><?php echo $provider->getOsKernelVersion() ?></dd>
                    </dl>
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-hdd-o"></i>
                    <h3 class="box-title"><?php echo Yii::t('admin', 'Time') ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt><?php echo Yii::t('admin', 'System Date') ?></dt>
                        <dd><?php echo Yii::$app->formatter->asDate(time()) ?></dd>

                        <dt><?php echo Yii::t('admin', 'System Time') ?></dt>
                        <dd><?php echo Yii::$app->formatter->asTime(time()) ?></dd>

                        <dt><?php echo Yii::t('admin', 'Timezone') ?></dt>
                        <dd><?php echo date_default_timezone_get() ?></dd>
                    </dl>
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-hdd-o"></i>
                    <h3 class="box-title"><?php echo Yii::t('admin', 'Network') ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt><?php echo Yii::t('admin', 'Hostname') ?></dt>
                        <dd><?php echo $provider->getHostname() ?></dd>

                        <dt><?php echo Yii::t('admin', 'Internal IP') ?></dt>
                        <dd><?php echo $provider->getServerIP() ?></dd>

                        <dt><?php echo Yii::t('admin', 'External IP') ?></dt>
                        <dd><?php echo $provider->getExternalIP() ?></dd>

                        <dt><?php echo Yii::t('admin', 'Port') ?></dt>
                        <dd><?php echo $provider->getServerVariable('SERVER_PORT') ?></dd>
                    </dl>
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-hdd-o"></i>
                    <h3 class="box-title"><?php echo Yii::t('admin', 'Software') ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt><?php echo Yii::t('admin', 'Web Server') ?></dt>
                        <dd><?php echo $provider->getServerSoftware() ?></dd>

                        <dt><?php echo Yii::t('admin', 'PHP Version') ?></dt>
                        <dd><?php echo $provider->getPhpVersion() ?></dd>

                        <dt><?php echo Yii::t('admin', 'DB Type') ?></dt>
                        <dd><?php echo $provider->getDbType(Yii::$app->db->pdo) ?></dd>

                        <dt><?php echo Yii::t('admin', 'DB Version') ?></dt>
                        <dd><?php echo $provider->getDbVersion(Yii::$app->db->pdo) ?></dd>
                    </dl>
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-hdd-o"></i>
                    <h3 class="box-title"><?php echo Yii::t('admin', 'Memory') ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt><?php echo Yii::t('admin', 'Total memory') ?></dt>
                        <dd><?php echo Yii::$app->formatter->asSize($provider->getTotalMem()) ?></dd>

                        <dt><?php echo Yii::t('admin', 'Free memory') ?></dt>
                        <dd><?php echo Yii::$app->formatter->asSize($provider->getFreeMem()) ?></dd>

                        <dt><?php echo Yii::t('admin', 'Total Swap') ?></dt>
                        <dd><?php echo Yii::$app->formatter->asSize($provider->getTotalSwap()) ?></dd>

                        <dt><?php echo Yii::t('admin', 'Free Swap') ?></dt>
                        <dd><?php echo Yii::$app->formatter->asSize($provider->getFreeSwap()) ?></dd>
                    </dl>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        <?php echo gmdate('H:i:s', $provider->getUptime()) ?>
                    </h3>
                    <p>
                        <?php echo Yii::t('admin', 'Uptime') ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="small-box-footer">
                    &nbsp;
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        <?php echo $provider->getLoadAverage() ?>
                    </h3>
                    <p>
                        <?php echo Yii::t('admin', 'Load average') ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <div class="small-box-footer">
                    &nbsp;
                </div>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        <?php echo User::find()->count() ?>
                    </h3>
                    <p>
                        <?php echo Yii::t('admin', 'User Registrations') ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo Yii::$app->urlManager->createUrl(['/user/index']) ?>" class="small-box-footer">
                    <?php echo Yii::t('admin', 'More info') ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>
                        <?php echo FileStorageItem::find()->count() ?>
                    </h3>
                    <p>
                        <?php echo Yii::t('admin', 'Files in storage') ?>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="<?php echo Yii::$app->urlManager->createUrl(['/file-storage/index']) ?>" class="small-box-footer">
                    <?php echo Yii::t('admin', 'More info') ?> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div id="cpu-usage" class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                        <?php echo Yii::t('admin', 'CPU Usage') ?>
                    </h3>
                    <div class="box-tools pull-right">
                        <?php echo Yii::t('admin', 'Real time') ?>
                        <div class="realtime btn-group" data-toggle="btn-toggle">
                            <button type="button" class="btn btn-default btn-xs active" data-toggle="on">
                                <?php echo Yii::t('admin', 'On') ?>
                            </button>
                            <button type="button" class="btn btn-default btn-xs" data-toggle="off">
                                <?php echo Yii::t('admin', 'Off') ?>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart" style="height: 300px;">
                    </div>
                </div><!-- /.box-body-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div id="memory-usage" class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">
                        <?php echo Yii::t('admin', 'Memory Usage') ?>
                    </h3>
                    <div class="box-tools pull-right">
                        <?php echo Yii::t('admin', 'Real time') ?>
                        <div class="btn-group realtime" data-toggle="btn-toggle">
                            <button type="button" class="btn btn-default btn-xs active" data-toggle="on">
                                <?php echo Yii::t('admin', 'On') ?>
                            </button>
                            <button type="button" class="btn btn-default btn-xs" data-toggle="off">
                                <?php echo Yii::t('admin', 'Off') ?>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart" style="height: 300px;">
                    </div>
                </div><!-- /.box-body-->
            </div>
        </div>
    </div>
</div>
