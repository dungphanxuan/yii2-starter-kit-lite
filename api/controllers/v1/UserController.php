<?php

namespace api\controllers\v1;

use api\controllers\ApiController;
use api\models\SignupForm;
use cheatsheet\Time;
use common\models\User;
use common\models\UserToken;
use Yii;

class UserController extends ApiController
{
    public $defaultAction = 'login';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'login'  => ['post'],
                    'sign-up'  => ['post'],
                    'logout'  => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex(){
        $this->msg = 'User Controller';
    }

    /*
    * Login api
    * @param string $identity Username or email
    * @param string $password Password
    * @return Thong tin xac thuc, access token
    * */
    public function actionLogin(){
        $get_identity = postParam('identity', '');
        $get_password = postParam('password', '');
        if (empty($get_identity) || empty($get_password)) {
            $this->msg = "Missing username or password.";
            $this->code = 422;
            $this->data = $_POST;
        } else {
            $login = $this->login($get_identity, $get_password);
            $this->code = $login['status'];
            $this->msg = $login['msg'];
            $this->data = $login['result'];
        }
    }

    public function actionSignUp(){
        $get_email = postParam('email', '');
        //$get_username = getParam('username', true, '');
        $get_password = postParam('password', '');
        if (empty($get_email) || empty($get_password) ) {
            $this->msg = "Missing email or password";
            $this->code = 422;
        } else {
            $model = new SignupForm();
            $model->email = $get_email;
            $model->username = $get_email;
            $model->password = $get_password;

            $data = $model->validate();
            if($data){
                $user = $model->signup();
                if ($user && Yii::$app->getUser()->login($user)) {
                    //Process
                }
                $this->msg = "Register success.";
            }else{
                $this->code = 422;
                $error = $model->getFirstErrors();
                if(isset($error)){
                    $this->msg = reset($error);;
                }
            }
        }
    }

    public function actionLogout(){
        $token = postParam('token', '');
        if (empty($token)) {
            $this->msg = "Missing token";
            $this->code = 0;
        }else{
            $token = UserToken::find()
                ->byType(UserToken::TYPE_USER_API)
                ->byToken($token)
                ->notExpired()
                ->one();

            if (!$token) {
                $this->msg = "Bad Request";
                $this->code = 400;
            }

            $token->delete();

            $this->msg = "Logout success";
            $this->code = 1;
        }
    }

    /*
     * Authenticator
     * */
    private function login($identity, $password, $auto = false)
    {
        $status = 0;
        $msg = '';
        $result = array();

        //Check account infor
        /**
         * @var User $user
         */
        $user = User::findByLogin($identity);
        if($user){
            if($user->status){
                $validPassword = $user->validatePassword($password);
                if($validPassword){
                    /** @var UserToken $tokenModel */
                    $tokenModel = UserToken::find()
                        ->notExpired()
                        ->byType(UserToken::TYPE_USER_API)
                        ->byUser($user->id)
                        ->one();

                    if (!$this->token) {
                        $status = 1;
                        $msg = "Login success.";
                        $result = $tokenModel->token;
                    } else{
                        //Generate Token
                        $token = UserToken::create($user->id, UserToken::TYPE_USER_API, Time::SECONDS_IN_A_DAY);
                        $status = 200;
                        $msg = "Login success.";
                        $result = $token->token;
                    }
                }else{
                    $status = 400;
                    $msg = "Wrong password";
                }
            }else{
                $status = 400;
                $msg = "Account not active";
            }
        }else{
            $status = 400;
            $msg = "Account not register";
        }
        return array(
            'status' => $status,
            'msg' => $msg,
            'result' => $result
        );
    }

}
