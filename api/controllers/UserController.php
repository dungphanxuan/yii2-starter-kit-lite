<?php

namespace api\controllers;

use api\components\AccessTokenAuth;
use api\controllers\ApiController;
use api\models\SignupForm;
use cheatsheet\Time;
use common\models\User;
use common\models\UserToken;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class UserController extends ApiController
{
    public $defaultAction = 'index';


    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'login' => ['post'],
                    'sign-up' => ['post'],
                    'logout' => ['post'],
                ],
            ],
            'authenticator' => [
                'class' => AccessTokenAuth::className(),
                'except' => ['index', 'login', 'sign-up'],
            ]
        ]);
    }

    public function actionIndex()
    {
        $this->msg = 'User Controller';
    }

    /*
    * Get user info
    * @param int $id User id
    * @return User info
    * */
    public function actionInfo()
    {
        $uid = getParam('id', null);
        if (!$uid) {
            $uid = getMyId();
        }
        if (!empty($uid)) {

            $useModel = User::find()->active()->where(['id' => $uid])->one();
            if ($useModel) {
                $this->msg = 'User Info';
                $this->data = User::getDetail($uid);
            } else {
                $this->code = 404;
                $this->msg = 'User Not found';
            }
        } else {
            $this->code = 422;
            $this->msg = 'Id is require';
        }

    }

    /*
    * Login api
    * @param string $identity Username or email
    * @param string $password Password
    * @return User info, access token
    * */
    public function actionLogin()
    {

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


    /*
    * SignUp api
    * @param string $email User email
    * @param string $password User password
    * @return mixed
    * */
    public function actionSignUp()
    {
        $get_email = postParam('email', '');
        //$get_username = getParam('username', true, '');
        $get_password = postParam('password', '');
        if (empty($get_email) || empty($get_password)) {
            $this->msg = "Missing email or password";
            $this->code = 422;
        } else {
            $model = new SignupForm();
            $model->email = $get_email;
            $model->username = $get_email;
            $model->password = $get_password;

            $data = $model->validate();
            if ($data) {
                $user = $model->signup();
                if ($user && Yii::$app->getUser()->login($user)) {
                    //Process
                }
                $this->msg = "Register success.";
            } else {
                $this->code = 422;
                $error = $model->getFirstErrors();
                if (isset($error)) {
                    $this->msg = reset($error);;
                }
            }
        }
    }

    /**
     * User logout
     *
     * @param string $token User token
     * @return mixed
     */
    public function actionLogout()
    {
        $token = postParam('token', '');
        if (empty($token)) {
            $this->msg = "Missing token";
            $this->code = 422;
        } else {
            $token = UserToken::find()
                ->byType(UserToken::TYPE_USER_API)
                ->byToken($token)
                ->notExpired()
                ->one();

            if (!$token) {
                $this->msg = "Bad Request: Token not found";
                $this->code = 400;
            } else {
                $token->delete();
                $this->msg = "Logout success";
                $this->code = 200;
            }
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
        $user = User::findUserLogin($identity);
        if ($user) {
            if ($user->status == 2) {
                $validPassword = $user->validatePassword($password);
                if ($validPassword) {
                    /** @var UserToken $tokenModel */
                    $tokenModel = UserToken::find()
                        ->notExpired()
                        ->byType(UserToken::TYPE_USER_API)
                        ->byUser($user->id)
                        ->one();

                    $dataUser = [
                        'user_id' => $user->id,
                        'username' => $user->username,
                        'access_token' => Yii::$app->security->generateRandomString(40),
                    ];
                    if ($tokenModel) {
                        $status = 200;
                        $msg = "Login success.";
                        $dataUser['access_token'] = $tokenModel->token;
                        $dataUser['expires'] = $tokenModel->expire_at;
                        $result = $dataUser;
                    } else {
                        //Generate Token
                        $loginTime = Time::SECONDS_IN_A_DAY;
                        $token = UserToken::create($user->id, UserToken::TYPE_USER_API, $loginTime);
                        $status = 200;
                        $msg = "Login success.";
                        $dataUser['access_token'] = $token->token;
                        $dataUser['expires'] = time() + $loginTime;
                        $result = $dataUser;
                    }
                } else {
                    $status = 400;
                    $msg = "Wrong password";
                }
            } else {
                $status = 400;
                $msg = "Account not active";
            }
        } else {
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
