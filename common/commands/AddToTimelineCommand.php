<?php

namespace common\commands;

use common\models\TimelineEvent;
use trntv\bus\interfaces\SelfHandlingCommand;
use Yii;
use yii\base\Object;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class AddToTimelineCommand extends Object implements SelfHandlingCommand
{
    /**
     * @var string
     */
    public $category;
    /**
     * @var string
     */
    public $event;
    /**
     * @var mixed
     */
    public $data;

    /**
     * @param AddToTimelineCommand $command
     *
     * @return bool
     */
    public function handle($command)
    {
        $model = new TimelineEvent();
        $model->application = Yii::$app->id;
        $model->category = $command->category;
        $model->event = $command->event;
        $model->data = json_encode($command->data, JSON_UNESCAPED_UNICODE);

        return $model->save(false);
    }
}
