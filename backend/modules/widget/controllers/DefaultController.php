<?php

namespace backend\modules\widget\controllers;

use yii\web\Controller;

/**
 * Default controller for the `widget` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
