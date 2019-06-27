<?php

namespace api\components;

/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

use Yii;
use yii\filters\auth\AuthMethod;

/**
 * QueryParamAuth is an action filter that supports the authentication based on the access token passed through a query parameter.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class SessionAuth extends AuthMethod
{
    /**
     * @var string the parameter name for passing the access token
     */
    public $tokenParam = 'sid';

    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {

        $accessToken = $request->get($this->tokenParam);

        if (is_string($accessToken)) {

            Yii::$app->session->id = $accessToken;

            $identity = isset(Yii::$app->session['loggedUser']) ? Yii::$app->session['loggedUser'] : null;

            if ($identity !== null) {
                return $identity;
            }
        }
        if ($accessToken !== null) {
            $this->handleFailure($response);
        }

        return null;
    }

}
