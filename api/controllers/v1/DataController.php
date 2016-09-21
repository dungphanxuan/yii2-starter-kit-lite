<?php

namespace api\controllers\v1;

use api\controllers\ApiController;

class DataController extends ApiController
{

    public function actionIndex(){
        $this->msg = 'Data Controller';
    }
}
