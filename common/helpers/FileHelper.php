<?php

namespace common\helpers;


use yii\helpers\Inflector;

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