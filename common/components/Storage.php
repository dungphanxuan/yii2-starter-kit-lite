<?php
namespace common\components;

use League\Flysystem\FilesystemInterface;
use trntv\filekit\events\StorageEvent;
use trntv\filekit\filesystem\FilesystemBuilderInterface;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Class Storage
 * @package trntv\filekit
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Storage extends \trntv\filekit\Storage
{

    /**
     * @param $file string|\yii\web\UploadedFile
     * @param bool $preserveFileName
     * @param bool $overwrite
     * @return bool|string
     */
    public function save($file, $preserveFileName = false, $overwrite = false, $fname = '')
    {
        $fileObj = File::create($file);
        $dirIndex = $this->getDirIndex();
        if ($preserveFileName === false) {
            do {

                if(empty($fname)){
                    $filename = implode('.', [
                        \Yii::$app->security->generateRandomString(9) . '_'. time(),
                        $fileObj->getExtension()
                    ]);
                }else{
                    $filename = implode('.', [
                        $fname . '_' . time(),
                        $fileObj->getExtension()
                    ]);
                }
                $path = implode('/', [$dirIndex, $filename]);
            } while ($this->getFilesystem()->has($path));
        } else {
            $filename = $fileObj->getPathInfo('filename');
            $path = implode('/', [$dirIndex, $filename]);
        }

        $this->beforeSave($fileObj->getPath(), $this->getFilesystem());

        $stream = fopen($fileObj->getPath(), 'r+');
        if ($overwrite) {
            $success = $this->getFilesystem()->putStream($path, $stream);
        } else {
            $success = $this->getFilesystem()->writeStream($path, $stream);
        }
        fclose($stream);

        if ($success) {
            $this->afterSave($path, $this->getFilesystem());
            return $path;
        }

        return false;

    }
}
