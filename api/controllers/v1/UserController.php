<?php

namespace api\controllers\v1;

use api\controllers\ApiController;
use common\helpers\UserHelper;
use common\models\User;


/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class UserController extends ApiController
{

    /**
     * Get User Info
     *
     * @param integer $id
     *
     */
    public function actionInfo(){
        $user_id = getParam('id');
        if(!$user_id){
            $user_id = $this->uid;
        }
        if(!empty($user_id)){
            $this->code = 200;
            $this ->msg ="User Info";
            $this->data = UserHelper::getInfo($user_id, true);
        }else{
            $this->code =422;
            $this ->msg ="Require User Id";
        }

    }
}
