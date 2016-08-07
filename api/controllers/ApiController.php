<?php
namespace api\controllers;

use common\models\extend\AccessToken;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\base\Action;
/**
 * Site controller
 */
class ApiController extends Controller
{
    /**
     * @var integer App ID
     */
    public $app_id = 1;
    /**
     * @var array Data response
     */
    public $data = [];
    /**
     * @var string Message description
     */
    public $msg = "Ok";
    /**
     * @var int trạng thái kết quả của API, mặc định là lỗi
     */
    public $code = 200;

    /**
     * @var int ID của user
     */
    public $uid = 0;

    public function isPost()
    {
        return Yii::$app->request->getIsPost();
    }

    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
            ],
            [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'  => ['get'],
                    'view'   => ['get'],
                    'create' => ['post'],
                    'update' => ['put', 'post'],
                    'delete' => ['post', 'delete'],
                ]
            ]

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
            $get_app_id = getParam('app_id', '');
            if (empty($get_app_id)) {
                $this->code = 422;
                $this->msg = "Thiếu thông tin App ID";
                $this->senData($action);
                return false;
            }else{
                $app = true;
                if(!$app){
                    $this->code = 404;
                    $this->msg = "Không tồn tại App ID";
                    $this->senData($action);
                    return false;
                }else{
                    /*Save AppID info*/
                    $this->app_id = $get_app_id;

                    /*Validate user token!*/
                    $controler_id = $action->controller->id;
                    if (strtolower($action->uniqueId) != "site/error") {
                        $not_auth_controller_ids = ['site', 'auth', 'upload', 'article','test'];
                        if (!in_array(strtolower($controler_id), $not_auth_controller_ids)) {
                            //$result = AccessToken::verifyToken();
                           $result['message']['user_id'] =1;
                           $result['status'] =1;
                            if ($result['status'] == 0) {
                                $this->code = 401;
                                $this->msg = "Not Login";
                                $this->data = $result['message'];
                                $this->senData($action);
                                return false;
                            } else {
                                $this->uid = $result['message']['user_id'];
                            }
                        }
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
        if(!empty($this->data)){
            $response->data = $this->data;
        }
        return parent::afterAction($action, $result);
    }

}
