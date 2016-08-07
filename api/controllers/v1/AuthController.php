<?php

/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 9/18/13
 * Time: 9:42 AM
 * To change this template use File | Settings | File Templates.
 */
namespace api\controllers\v1;


use api\controllers\ApiController;
use common\models\AccessToken;
use common\models\OauthClients;
use Yii;
use yii\authclient\OAuthToken;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\helpers\Json;
use yii\base\Action;
use common\models\User;
use api\models\LoginForm;
use api\models\SignupForm;

class Authontroller extends ApiController
{
    /*
     * Xac thuc nguoi dung
     * @param string $username Ten nguoi dung
     * @param string $password Mat Khau
     * @return Thong tin xac thuc, access token
     * */
    public function actionLogin()
    {
        if ($this->isPost()) {
            $get_identity = getParam('identity', '');
            $get_password = getParam('password', '');
            if (empty($get_identity) || empty($get_password)) {
                $this->msg = "Thiếu thông tin username hoặc password";
                $this->status = 0;
                $this->result = $_POST;
            } else {
                $login = $this->login($get_identity, $get_password);
                $this->status = $login['status'];
                $this->msg = $login['msg'];
                $this->result = $login['result'];
            }
        } else {
            $this->status = 0;
            $this->msg = "Method not allow";
        }
    }

    public function actionLogout(){
        if ($this->isPost()) {
            $token = getParam('token', '');
            if (empty($token)) {
                $this->msg = "Thiếu thông tin";
                $this->status = 0;
            }else{
                $result = AccessToken::deleteToken($token);
                if($result){
                    $this->msg = "Đăng xuất thành công";
                    $this->status = 1;
                }else{
                    $this->msg = "Lỗi: Không tìm thấy token";
                    $this->status = 0;
                }
            }
        } else {
            $this->status = 0;
            $this->msg = "Method not allow";
        }
    }

    public function actionRegister()
    {
        if ($this->isPost()) {
            $get_email = getParam('email', '');
            //$get_username = getParam('username', true, '');
            $get_password = getParam('password', '');
            if (empty($get_email)) {
                $this->msg = "Thiếu thông tin email";
                $this->status = 0;
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
                    $this->status = 1;
                    $this->msg = "Đăng ký thành công.";
                }else{
                    $this->status = 0;
                    $error = $model->getErrors();
                    if(isset($error['email'])){
                        $this->msg = $error['email'];
                    }elseif(isset($error['password'])){
                        $this->msg = $error['password'];
                    }elseif(isset($error['username'])){
                        $this->msg = $error['username'];
                    }
                }
            }
        } else {
            $this->status = 0;
            $this->msg = "Method not allow";
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
        $user = User::findIdentity($identity);
        if($user){
            if($user->status){
                $validPassword = $user->validatePassword($password);
                if($validPassword){
                    $isExpiress = AccessToken::getTokenById($user->id);
                    if($isExpiress){
                        $status = 1;
                        $msg = "Đăng nhập thành công.";
                        $result = $isExpiress;
                    }else{
                        //Generate Token
                        $dataOAuth = array(
                            'user_id' => $user->id,
                            'access_token' => Yii::$app->security->generateRandomString(40),
                            'expires' => time()+ (7 * 24 * 60 * 3600)
                        );

                        $dataToken = AccessToken::addToken($dataOAuth);
                        $status = 1;
                        $msg = "Đăng nhập thành công.";
                        $result = $dataToken;
                    }

                }else{
                    $status = 0;
                    $msg = "Mật khẩu không đúng";
                }
            }else{
                $status = 0;
                $msg = "Tài khoản chưa được kích hoạt";
            }
        }else{
            $status = 0;
            $msg = "Tài khoản chưa được đăng ký";
        }
        return array(
            'status' => $status,
            'msg' => $msg,
            'result' => $result
        );
    }


}