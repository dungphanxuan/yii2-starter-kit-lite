<?php

namespace backend\controllers;

use common\components\keyStorage\FormModel;
use common\models\FileStorageItem;
use common\models\User;
use common\task\DownloadTask;
use Yii;

/**
 * Site controller
 */
class SiteController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = Yii::$app->user->isGuest || !Yii::$app->user->can('loginToBackend') ? 'base' : 'common';

        return parent::beforeAction($action);
    }

    public function actionSettings()
    {
        $model = new FormModel([
            'keys' => [
                'frontend.maintenance' => [
                    'label' => Yii::t('backend', 'Frontend maintenance mode'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        'disabled' => Yii::t('backend', 'Disabled'),
                        'enabled' => Yii::t('backend', 'Enabled')
                    ]
                ],
                'backend.theme-skin' => [
                    'label' => Yii::t('backend', 'Backend theme'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        'skin-black' => 'skin-black',
                        'skin-blue' => 'skin-blue',
                        'skin-green' => 'skin-green',
                        'skin-purple' => 'skin-purple',
                        'skin-red' => 'skin-red',
                        'skin-yellow' => 'skin-yellow'
                    ]
                ],
                'backend.layout-fixed' => [
                    'label' => Yii::t('backend', 'Fixed backend layout'),
                    'type' => FormModel::TYPE_CHECKBOX
                ],
                'backend.layout-boxed' => [
                    'label' => Yii::t('backend', 'Boxed backend layout'),
                    'type' => FormModel::TYPE_CHECKBOX
                ],
                'backend.layout-collapsed-sidebar' => [
                    'label' => Yii::t('backend', 'Backend sidebar collapsed'),
                    'type' => FormModel::TYPE_CHECKBOX
                ]
            ]
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', [
                'body' => Yii::t('backend', 'Settings was successfully saved'),
                'options' => ['class' => 'alert alert-success']
            ]);

            return $this->refresh();
        }

        return $this->render('settings', ['model' => $model]);
    }

    /*
     * ChartJS
     * */
    public function actionChart()
    {
        $dateRange = getParam('date_range_1', date('Y-m-d', strtotime('-7 day')) . '-' . date('Y-m-d'));
        $fromDate = strtotime(substr($dateRange, 0, 10));
        $toDate = strtotime(substr($dateRange, 11));
        $arrLabel = [];
        $dataDate = [];
        while ($fromDate <= $toDate) {
            $tsStartOfDay = strtotime("midnight", $fromDate);
            $cacheKey = [
                'statfilelog',
                $tsStartOfDay
            ];
            $totalInDay = FileStorageItem::find()
                ->andWhere(
                    ['between', 'created_at', $tsStartOfDay, $tsStartOfDay + 86399])
                ->count();
            $arrLabel[] = date('Y-m-d', $fromDate);
            $dataDate[] = $totalInDay;
            //Increment 1 day
            $fromDate = strtotime("+1 day", $fromDate);
        }
        $arrDataset[] = [
            'label' => 'Upload Stat',
            'backgroundColor' => "rgba(255,99,132,0.2)",
            'borderColor' => "rgba(255,99,132,1)",
            'pointBackgroundColor' => "rgba(255,99,132,1)",
            'fill' => false,
            'data' => $dataDate,
        ];

        return $this->render('chart', [
            'dateRange' => $dateRange,
            'arrLabel' => $arrLabel,
            'arrDataset' => $arrDataset
        ]);
    }

    public function actionTest()
    {
        $use1 = 'dungpx.s@gmail.com';
        $user = User::find()->active()
            //->andWhere(['or', ['username' =>$use1 ], ['email' => $use1]])
            ->asArray()
            ->all();
        php_dump($user);
        // create task
        $task = new DownloadTask(['url' => 'http://localhost/', 'file' => '/tmp/localhost.html']);
        \Yii::$app->async->sendTask($task);
    }

}
