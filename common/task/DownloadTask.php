<?php
/**
 * Created by PhpStorm.
 * User: dungphanxuan
 * Date: 11/29/2016
 * Time: 10:55 AM
 */

namespace common\task;

/*
 * Example
 * Create task
 * $task = new DownloadTask(['url' => 'http://localhost/', 'file' => '/tmp/localhost.html']);
 * \Yii::$app->async->sendTask($task);
 *
 * Execute:
 * while ($task = \Yii::$app->async->receiveTask('downloads')) {
 *      if ($task->execute()) {
 *        \Yii::$app->async->acknowledgeTask($task);
 *       }
 * }
 * */
use bazilio\async\models\AsyncTask;

class DownloadTask extends AsyncTask
{
    public $url;
    public $file;
    public static $queueName = 'downloads';

    public function execute()
    {
        return file_put_contents($this->file, file_get_contents($this->url));
    }
}
