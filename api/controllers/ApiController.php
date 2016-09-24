<?php
namespace api\controllers;

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

    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
            ],

        ], parent::behaviors());

    }

    /**
     * @param $controller
     * @param $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            header('Content-Type: text/html; charset=utf-8');
            /*Validate user token!*/
            $cid = $action->controller->id;
            if (strtolower($action->uniqueId) != "site/error") {
                $publicControlers = ['site', 'auth', 'test'];
                if (!in_array(strtolower($cid), $publicControlers)) {
                    $get_token = getParam('token', null);
                    /** @var UserToken $tokenModel */
                    $tokenModel = UserToken::find()
                        ->notExpired()
                        ->byType(UserToken::TYPE_USER_API)
                        ->byToken($get_token)
                        ->one();

                    if (!$tokenModel) {
                        $this->code = 401;
                        $this->msg = "401 Unauthorized ";
                        return $this->senData($action);
                    } else {
                        $this->uid = $tokenModel->user_id;
                    }

                }
            }
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
