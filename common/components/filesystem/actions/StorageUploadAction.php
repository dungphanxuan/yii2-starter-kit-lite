<?php
/**
 * Created by PhpStorm.
 * User: dungpx
 * Date: 2/27/2018
 * Time: 11:21 AM
 */

namespace common\components\filesystem\actions;

use common\models\FileStorageItem;
use League\Flysystem\FilesystemInterface;
use trntv\filekit\events\UploadEvent;
use League\Flysystem\File as FlysystemFile;
use Yii;
use yii\base\DynamicModel;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\UploadedFile;

use trntv\filekit\actions\UploadAction;

/*
 * Class StorageUploadAction
 * Upload Action: Google Cloud Storage
 * 1. Upload
 * 2. Logging
 * 3. Thumbnail
 * */

class StorageUploadAction extends UploadAction
{
    const EVENT_AFTER_SAVE = 'afterSave';

    /**
     * @var string
     */
    public $fileparam = 'file';

    /**
     * @var bool
     */
    public $multiple = true;

    /**
     * @var bool
     */
    public $disableCsrf = true;

    /**
     * @var string
     */
    public $responseFormat = Response::FORMAT_JSON;

    /**
     * @var string
     */
    public $responsePathParam = 'path';
    /**
     * @var string
     */
    public $responseBaseUrlParam = 'base_url';
    /**
     * @var string
     */
    public $responseUrlParam = 'url';
    /**
     * @var string
     */
    public $responseDeleteUrlParam = 'delete_url';
    /**
     * @var string
     */
    public $responseMimeTypeParam = 'type';
    /**
     * @var string
     */
    public $responseNameParam = 'name';
    /**
     * @var string
     */
    public $responseSizeParam = 'size';
    /**
     * @var string
     */
    public $deleteRoute = 'delete';

    /**
     * @var array
     * @see https://github.com/yiisoft/yii2/blob/master/docs/guide/input-validation.md#ad-hoc-validation-
     */
    public $validationRules;

    public $base_url = 'https://storage.googleapis.com/yii_bucket';

    /**
     *
     */
    public function init()
    {
        \Yii::$app->response->format = $this->responseFormat;

        if (\Yii::$app->request->get('fileparam')) {
            $this->fileparam = \Yii::$app->request->get('fileparam');
        }

        if ($this->disableCsrf) {
            \Yii::$app->request->enableCsrfValidation = false;
        }
    }

    /**
     * @return array
     * @throws \HttpException
     */
    public function run()
    {
        $result = [];
        $uploadedFiles = UploadedFile::getInstancesByName($this->fileparam);

        foreach ($uploadedFiles as $uploadedFile) {
            /* @var \yii\web\UploadedFile $uploadedFile */
            $output = [
                $this->responseNameParam     => Html::encode($uploadedFile->name),
                $this->responseMimeTypeParam => $uploadedFile->type,
                $this->responseSizeParam     => $uploadedFile->size,
                //$this->responseBaseUrlParam  => $this->getFileStorage()->baseUrl
                $this->responseBaseUrlParam  => $this->base_url
            ];
            if ($uploadedFile->error === UPLOAD_ERR_OK) {
                $validationModel = DynamicModel::validateData(['file' => $uploadedFile], $this->validationRules);
                if (!$validationModel->hasErrors()) {
                    $dirIndex = implode('/', [date('Y'), date('m')]);
                    $filename = implode('.', [
                        time() . Yii::$app->security->generateRandomString(),
                        $uploadedFile->getExtension()
                    ]);
                    $filePath = implode('/', [$dirIndex, $filename]);
                    //$path = $this->getFileStorage()->save($uploadedFile);
                    //todo Google Cloud Storage Upload file
                    //$path = '1/022018/27K1u8iz2UfUjYmK810-3sJdLBfsL7Zezq.jpg';
                    $path = Yii::$app->cloudStorage->upload($uploadedFile);

                    if ($path) {
                        $output[$this->responsePathParam] = $path;
                        $output[$this->responseUrlParam] = $this->base_url . '/' . $path;
                        $output[$this->responseDeleteUrlParam] = Url::to([$this->deleteRoute, 'path' => $path]);
                        $paths = \Yii::$app->session->get($this->sessionKey, []);
                        $paths[] = $path;
                        \Yii::$app->session->set($this->sessionKey, $paths);
                        $this->afterSave($path, $uploadedFile);

                    } else {
                        $output['error'] = true;
                        $output['errors'] = [];
                    }

                } else {
                    $output['error'] = true;
                    $output['errors'] = $validationModel->getFirstError('file');
                }
            } else {
                $output['error'] = true;
                $output['errors'] = $this->resolveErrorMessage($uploadedFile->error);
            }

            $result['files'][] = $output;
        }
        return $this->multiple ? $result : array_shift($result);
    }

    /**
     * @param $path
     * @param $file \yii\web\UploadedFile
     */
    public function afterSave($path, $file = null)
    {
        $model = new FileStorageItem();
        $model->component = 'storage';
        $model->path = $path;
        $model->base_url = $this->base_url;
        $model->size = $file->size;
        $model->type = $file->type;
        $model->name = $file->name;
        if (Yii::$app->request->getIsConsoleRequest() === false) {
            $model->upload_ip = Yii::$app->request->getUserIP();
        }
        $model->save(false);

        //Push Vision Job to check secure Image

        return true;
    }

}