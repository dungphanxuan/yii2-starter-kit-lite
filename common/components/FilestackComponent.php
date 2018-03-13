<?php
/**
 * Created by PhpStorm.
 * User: dungpx
 * Date: 10/5/2017
 * Time: 9:41 AM
 */

namespace common\components;


use Filestack\Filelink;
use Filestack\FilestackClient;
use Filestack\FilestackSecurity;
use yii\base\Component;
use yii\httpclient\Client;

/*
 * Class FilestackComponent
 * Feature: Upload, Delete, Download, Overwride, Get Content
 * Get Metadata, Zip, Url Screenshot, Transformation
 * @author  Dung Phan Xuan <dungphanxuan999@gmail.com>
 * */

class FilestackComponent extends Component
{
    /**
     * @var string
     */
    public $api_key;

    /**
     * @var string
     */
    public $app_secret;

    /**
     * @var FilestackClient
     */
    public $client;

    public function init()
    {
        parent::init();
        //$client = new FilestackClient($this->api_key);
        $security = new FilestackSecurity('APP_SECRET');
        $this->client = new FilestackClient($this->api_key, $security);
    }

    /**
     * @param       $file string|\yii\web\UploadedFile
     * @return string File Path
     */
    public function upload($file = null)
    {
        /** @var Filelink $filelink */
        $filelink = $this->client->upload($file->tempName, ['filename' => $file->name]);

        //$filePath =  $filelink->url();
        $filePath = $filelink->handle;

        return $filePath;
    }

    public function uploadUrl($url)
    {
        /** @var Filelink $filelink */
        $filelink = $this->client->upload($url);

        //$filePath =  $filelink->url();
        $filePath = $filelink->handle;

        return $filePath;
    }

    /**
     * Returns Filestack client
     * @return FilestackClient
     */
    public function getClient()
    {
        if (!isset($this->client)) {
            $this->client = new FilestackClient($this->api_key);
        }

        return $this->client;
    }

    public function delete($hander)
    {
        $security = new FilestackSecurity(env('FILESTACK_API_SECRET'));
        $client = new FilestackClient(env('FILESTACK_API_KEY'), $security);
        //Todo check file hander exist
        $filelink = new Filelink($hander);
        $httpClient = new Client();
        $response = $httpClient->createRequest()
            ->setMethod('GET')
            ->setUrl($filelink->url())
            ->send();
        if ($response->isOk) {
            $client->delete($hander);
            return true;
        }

        return false;
    }
}