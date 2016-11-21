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
    public function actionIndex()
    {
        $this->msg = 'Api Component';
    }

    /*Action response as Html*/
    public function actionWeb()
    {
        $this->is_html = 1;
        return $this->render('web');
    }

}
