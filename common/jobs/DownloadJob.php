<?php
/**
 * Created by PhpStorm.
 * User: dungpx
 * Date: 10/4/2017
 * Time: 2:45 PM
 */

namespace common\jobs;


use Yii;
use yii\base\BaseObject;

class DownloadJob extends BaseObject implements \yii\queue\JobInterface
{
    public $url;
    public $file;

    public function execute($queue)
    {
        $storageAlias = Yii::getAlias('@storage');
        //file_put_contents(Yii::getAlias('@storage') . '/web/source/' . 3 . '.jpg', $image_Data);

        file_put_contents($this->file, file_get_contents($this->url));
    }
}