<?php
/**
 * Yii2 Shortcuts
 * @author Eugene Terentev <eugene@terentev.net>
 * -----
 * This file is just an example and a place where you can add your own shortcuts,
 * it doesn't pretend to be a full list of available possibilities
 * -----
 */

/**
 * @return int|string
 */
function getMyId()
{
    return Yii::$app->user->getId();
}

/**
 * @param string $view
 * @param array $params
 * @return string
 */
function render($view, $params = [])
{
    return Yii::$app->controller->render($view, $params);
}

/**
 * @param $url
 * @param int $statusCode
 * @return \yii\web\Response
 */
function redirect($url, $statusCode = 302)
{
    return Yii::$app->controller->redirect($url, $statusCode);
}

/**
 * @param $form \yii\widgets\ActiveForm
 * @param $model
 * @param $attribute
 * @param array $inputOptions
 * @param array $fieldOptions
 * @return string
 */
function activeTextinput($form, $model, $attribute, $inputOptions = [], $fieldOptions = [])
{
    return $form->field($model, $attribute, $fieldOptions)->textInput($inputOptions);
}

function cache()
{
    return Yii::$app->cache;
}

function dataCache()
{
    return Yii::$app->dcache;
}

/**
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function env($key, $default = false) {

    $value = getenv($key);

    if ($value === false) {
        return $default;
    }

    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;

        case 'false':
        case '(false)':
            return false;
    }

    return $value;
}

function baseUrl(){
    return Yii::$app->request->baseUrl;
}

function fileSystem(){
    return  Yii::$app->fileStorage->getFilesystem();
}

function getParam($name, $defaultValue = null)
{
    return Yii::$app->request->get($name, $defaultValue);
}

function postParam($name, $defaultValue = null)
{
    return Yii::$app->request->post($name, $defaultValue);
}

function isManager()
{
    return Yii::$app->user->can('manager');
}

function isAjax(){
    return Yii::$app->request->isAjax;
}

function isPost(){
    return Yii::$app->request->isPost;
}

function isMobile(){
    $mDetect = new \common\helpers\Mobile_Detect();
    return $mDetect->isMobile();
}

function isValidTimeStamp($timestamp)
{
    return ((string) (int) $timestamp === $timestamp)
    && ($timestamp <= PHP_INT_MAX)
    && ($timestamp >= ~PHP_INT_MAX);
}

function dd($data){
    echo "<pre>";
    var_dump($data);
    die;
}
