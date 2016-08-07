<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function actionIndex(){
        echo "ok";die;

    }

}
