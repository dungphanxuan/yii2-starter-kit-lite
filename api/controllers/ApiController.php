<?php
namespace api\controllers;

use api\components\AccessTokenAuth;
use common\models\UserToken;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\base\Action;

/**
 * Api controller
 */
class ApiController extends Controller
{
    /**
     * @var array Data response
     */
    public $data = [];
    /**
     * @var string Message description
     */
    public $msg = "Ok";
    /**
     * @var int Http code response
     */
    public $code = 200;

    /**
     * @var int User ID
     */
    public $uid = 0;

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }

    /**
     * @param $controller
     * @param $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            return true;
        } else
            return false;
    }

    /**
     * This method is invoked right after an action is executed.
     * @param Action $action the action just executed.
     * @return mixed|void
     */
    public function afterAction($action, $result)
    {
        return $this->senData($action, $result);
    }

    /**/
    protected function senData($action, $result = null)
    {
        header('Content-Type: text/html; charset=utf-8');
        $response = Yii::$app->getResponse();
        $response->setStatusCode($this->code);
        $response->statusText = $this->msg;
        if (!empty($this->data)) {
            $response->data = $this->data;
        }
        return parent::afterAction($action, $result);
    }

}
