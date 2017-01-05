<?php
/**
 * Created by PhpStorm.
 * User: Adnet
 * Date: 1/4/2017
 * Time: 9:06 AM
 */

namespace backend\grid;

use Yii;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * @var array
     */
    public $buttonClass = [
        'delete' => 'danger',
        'view' => 'success',
        'update' => 'info',
        'copy' => 'info',
        'item' => 'info',
        'task' => 'info',
        'search' => 'info'
    ];

    /**
     * @inheritdoc
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                $title = Yii::t('yii', ucfirst($name));
                $options = array_merge([
                    'title' => $title,
                    'class' => 'btn btn-xs btn-' . $this->buttonClass[$name],
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                return Html::a($icon, $url, $options);
            };
        }
    }

}