<?php

namespace api\controllers;

use api\components\AccessTokenAuth;
use yii\filters\AccessControl;

class TestController extends ApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => AccessTokenAuth::className(),
        ];
        return $behaviors;

    }
    public function behaviors1()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['user'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['user'],
                    'roles' => ['@'],
                ]
            ],
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $this->msg = 'Test Controller';
    }

    public function actionUser()
    {

        $this->msg = 'User login demo';
        $this->data = \Yii::$app->getUser()->getId();
    }
}
