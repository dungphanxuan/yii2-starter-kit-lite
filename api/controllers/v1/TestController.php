<?php

namespace api\controllers\v1;

use api\controllers\ApiController;

class TestController extends ApiController
{
    public function actionIndex(){
        $this->msg = 'Test Controller';
    }
}
