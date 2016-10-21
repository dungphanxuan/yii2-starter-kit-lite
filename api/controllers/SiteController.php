<?php
namespace api\controllers;

use Yii;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends ApiController
{
    /**
     * @inheritdoc
     */
    public function actionIndex(){
       $this->msg = 'Api Component';
    }

}
