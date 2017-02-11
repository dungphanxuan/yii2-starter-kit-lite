<?php
/**
 * Created by PhpStorm.
 * User: Co-Well
 * Date: 2/9/2017
 * Time: 4:33 PM
 */

namespace api\components;

use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

/*
 * ApiKeyFilter provides filter api access key
 * */

class ApiKeyFilter extends ActionFilter
{
    private $_api_key = null;

    /**
     * Initializes the api by.
     */
    public function init()
    {
        parent::init();
        $this->_api_key = getParam('api_key');
        if (!$this->_api_key) {
            $this->_api_key = postParam('api_key');
        }
    }

    public function beforeAction($action)
    {
        if ($this->_api_key !== env('API_KEY')) {
            $this->denyAccess();
        }
        return parent::beforeAction($action);
    }

    protected function denyAccess()
    {
        throw new ForbiddenHttpException(Yii::t('yii', 'The provided API key is invalid .'));
    }

}