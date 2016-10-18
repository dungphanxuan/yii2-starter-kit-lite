<?php
/**
 * @var $this yii\web\View
 */
use backend\assets_b\BackendAsset;
use backend\widgets\Menu;
use common\models\TimelineEvent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$bundle = BackendAsset::register($this);
?>
<?php $this->beginContent('@backend/views/layouts/base.php'); ?>
    <div class="wrapper">
        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="<?=Url::to(['/'])?>" class="navbar-brand"><b>Admin</b></a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">

                        <?php echo \yii\bootstrap\Nav::widget([
                            'options' => ['class' => 'nav navbar-nav'],
                            'items' => [
                                [
                                    'label'=>Yii::t('backend', 'Timeline'),
                                    'url'=>['/timeline-event/index']
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Articles'),
                                    'url'=>['/article/index']
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Content'),
                                    'url' => '#',
                                    'items'=>[
                                        ['label'=>Yii::t('backend', 'Static pages'), 'url'=>['/page/index']],
                                        ['label'=>Yii::t('backend', 'Articles'), 'url'=>['/article/index']],
                                        ['label'=>Yii::t('backend', 'Article Categories'), 'url'=>['/article-category/index']],
                                        ['label'=>Yii::t('backend', 'Text Widgets'), 'url'=>['/widget/widget-text/index']],
                                        ['label'=>Yii::t('backend', 'Menu Widgets'), 'url'=>['/widget/widget-menu/index']],
                                        ['label'=>Yii::t('backend', 'Carousel Widgets'), 'url'=>['/widget/widget-carousel/index']],

                                    ]
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Charts'),
                                    'url' => '#',
                                    'items'=>[
                                        ['label'=>Yii::t('backend', 'Request'), 'url'=>['/page/index']],
                                        ['label'=>Yii::t('backend', 'User'), 'url'=>['/statistic/user']],
                                    ]
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Users'),
                                    'url'=>['/user/index'],
                                    'visible'=>Yii::$app->user->can('administrator')
                                ],
                                [
                                    'label'=>Yii::t('backend', 'Other'),
                                    'url' => '#',
                                    'items'=>[
                                        [
                                            'label'=>Yii::t('backend', 'i18n'),
                                            'url' => '#',
                                            'items'=>[
                                                ['label'=>Yii::t('backend', 'i18n Source Message'), 'url'=>['/system/i18n-source-message/index'] ],
                                                ['label'=>Yii::t('backend', 'i18n Message'), 'url'=>['/system/i18n-message/index'] ],
                                            ],

                                        ],
                                        ['label'=>Yii::t('backend', 'Key-Value Storage'), 'url'=>['/system/key-storage/index']],
                                        ['label'=>Yii::t('backend', 'File Storage'), 'url'=>['/file-storage/index']],
                                        ['label'=>Yii::t('backend', 'Cache'), 'url'=>['/system/cache/index']],
                                        ['label'=>Yii::t('backend', 'File Manager'), 'url'=>['/system/file-manager/index'] ],
                                        [
                                            'label'=>Yii::t('backend', 'Logs'),
                                            'url'=>['/system/log/index'],
                                            'badgeBgClass'=>'label-danger',
                                        ],

                                    ]
                                ]

                            ]
                        ]); ?>
                    </div>
                    <!-- /.navbar-collapse -->
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li id="timeline-notifications" class="notifications-menu">
                                <a href="<?php echo Url::to(['/timeline-event/index']) ?>">
                                    <i class="fa fa-bell"></i>
                                <span class="label label-success">
                                    <?php echo TimelineEvent::find()->today()->count() ?>
                                </span>
                                </a>
                            </li>
                            <!-- Notifications: style can be found in dropdown.less -->
                            <li id="log-dropdown" class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-warning"></i>
                            <span class="label label-danger">
                                <?php echo \backend\models\SystemLog::find()->count() ?>
                            </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header"><?php echo Yii::t('backend', 'You have {num} log items', ['num'=>\backend\models\SystemLog::find()->count()]) ?></li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <?php foreach(\backend\models\SystemLog::find()->orderBy(['log_time'=>SORT_DESC])->limit(5)->all() as $logEntry): ?>
                                                <li>
                                                    <a href="<?php echo Yii::$app->urlManager->createUrl(['/system/log/view', 'id'=>$logEntry->id]) ?>">
                                                        <i class="fa fa-warning <?php echo $logEntry->level == \yii\log\Logger::LEVEL_ERROR ? 'text-red' : 'text-yellow' ?>"></i>
                                                        <?php echo $logEntry->category ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <?php echo Html::a(Yii::t('backend', 'View all'), ['/system/log/index']) ?>
                                    </li>
                                </ul>
                            </li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.png')) ?>" class="user-image">
                                    <span><?php echo Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header light-blue">
                                        <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.png')) ?>" class="img-circle" alt="User Image" />
                                        <p>
                                            <?php echo Yii::$app->user->identity->username ?>
                                            <small>
                                                <?php echo Yii::t('backend', 'Member since {0, date, short}', Yii::$app->user->identity->created_at) ?>
                                            </small>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <?php echo Html::a(Yii::t('backend', 'Profile'), ['/sign-in/profile'], ['class'=>'btn btn-default btn-flat']) ?>
                                        </div>
                                        <div class="pull-left">
                                            <?php echo Html::a(Yii::t('backend', 'Account'), ['/sign-in/account'], ['class'=>'btn btn-default btn-flat']) ?>
                                        </div>
                                        <div class="pull-right">
                                            <?php echo Html::a(Yii::t('backend', 'Logout'), ['/sign-in/logout'], ['class'=>'btn btn-default btn-flat', 'data-method' => 'post']) ?>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <?php echo Html::a('<i class="fa fa-cogs"></i>', ['/site/settings'])?>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-custom-menu -->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </header>
        <div class="content-wrapper">
            <div class="container">
                <!-- Right side column. Contains the navbar and content of the page -->
                <aside class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <h1>
                            <?= isset($this->context->heading)? $this->context->heading: $this->title ?>
                            <?php if (isset($this->params['subtitle'])): ?>
                                <small><?php echo $this->params['subtitle'] ?></small>
                            <?php endif; ?>
                        </h1>

                        <?php echo Breadcrumbs::widget([
                            'tag'=>'ol',
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            'homeLink' => [
                                'label' => '<i class="fa fa-dashboard"></i> '. Yii::t('yii', 'Home'),
                                'url' => Yii::$app->homeUrl,
                                'encode' => false,
                            ]
                        ]) ?>
                    </section>

                    <!-- Main content -->
                    <section class="content">
                        <?php if (Yii::$app->session->hasFlash('alert')):?>
                            <?php echo \yii\bootstrap\Alert::widget([
                                'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
                                'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
                            ])?>
                        <?php endif; ?>
                        <?php echo $content ?>
                    </section><!-- /.content -->
                </aside><!-- /.right-side -->
            </div>
            <!-- /.container -->
        </div>
        <footer class="main-footer">
            <div class="container">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0
                </div>
                <strong>Copyright &copy; <?=date('Y')?> <a href="<?=Yii::getAlias('@frontendUrl')?>"><?=Yii::$app->name?></a>.</strong> All rights
                reserved.
            </div>
            <!-- /.container -->
        </footer>
    </div><!-- ./wrapper -->


<?php $this->endContent(); ?>