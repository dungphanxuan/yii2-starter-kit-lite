<?php

namespace api\components;

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
use common\models\User;
use common\models\UserToken;
use yii\filters\auth\AuthMethod;
use Yii;
/**
 * AccessTokenAuth is an action filter that supports the authentication based on the access token passed through a query parameter.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Dung Phan Xuan <dungpx.s@gmail.com>
 * @since 2.0
 */
class AccessTokenAuth extends AuthMethod {
    /**
     * @var string the parameter name for passing the access token
     */
    public $tokenParam = 'token';
    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response) {

        /*Get token param*/
        $accessToken = $request->get($this->tokenParam);
        if(!$accessToken){
            $accessToken = $request->post($this->tokenParam);
        }

        if (is_string($accessToken)) {
            /** @var UserToken $tokenModel */
            $tokenModel = UserToken::find()
                ->notExpired()
                ->byType(UserToken::TYPE_USER_API)
                ->byToken($accessToken)
                ->one();

            if($tokenModel){
                $identity = User::findOne($tokenModel->user_id);
                $dataUser = $user->login($identity);
                if ($dataUser !== null) {
                    return $dataUser;
                }
            }
        }
        if ($accessToken !== null) {
            $this -> handleFailure($response);
        }
        return null;
    }

}
