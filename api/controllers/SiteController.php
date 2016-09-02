<?php
namespace api\controllers;

use Yii;

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
