<?php

namespace api\controllers;

use api\controllers\ApiController;

class DataController extends ApiController
{

    public function actionIndex()
    {
        $this->msg = 'Data Controller';
    }
}
