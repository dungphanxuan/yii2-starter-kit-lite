<?php

namespace api\components;

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
use common\models\AccessToken;
use yii\filters\auth\AuthMethod;
use Yii;
/**
 * QueryParamAuth is an action filter that supports the authentication based on the access token passed through a query parameter.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TokenAuth extends AuthMethod {
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

            $identity = $user->loginByAccessToken($accessToken, get_class($this));
            if ($identity !== null) {
                return $identity;
            }

        }
        if ($accessToken !== null) {
            $this -> handleFailure($response);
        }
        return null;
    }

}
