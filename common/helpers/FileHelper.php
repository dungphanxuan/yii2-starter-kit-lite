<?php

namespace common\helpers;

use api\models\SignupForm;
use common\models\User;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Inflector;
use Auth0\SDK\Auth0;
use yii\helpers\Json;

/**
 * Collection of useful helper functions for Yii Applications
 *
 * @author dungphanxuan <dungpx.na@gmail.vn>
 * @since 1.0
 *
 */
class FileHelper extends Inflector
{

    /*Get File name without extendsion*/
    public static function getFileInfo($fileName)
    {
        $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
        $a = Inflector::slug($withoutExt);
        return substr($a, 0, 40);
    }


}