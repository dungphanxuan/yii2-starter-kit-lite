<?php
/**
 * Created by PhpStorm.
 * User: dungpx
 * Date: 10/5/2017
 * Time: 9:41 AM
 */

namespace common\components\google;

use Google\Cloud\Storage\StorageClient;
use trntv\filekit\File;
use yii\base\Component;
use yii\web\UploadedFile;
use Yii;

/**
 * Class StorageComponent
 * @author  Dung Phan Xuan <dungphanxuan999@gmail.com>
 */
class StorageComponent extends Component
{
    /**
     * @var string
     */
    public $appId;

    /**
     * @var string
     */
    public $project_id;
    /**
     * @var string
     */
    public $bucket;

    /**
     * @var string
     */
    public $key_file_name;

    /*
     * @var StorageClient
     * */
    private $client;

    public function init()
    {
        parent::init();
        $keyFilePath = getStoragePath() . '\key\YiiGroup-797194353469.json';

        $this->client = new StorageClient([
            'projectId' => $this->project_id,
            'keyFile'   => json_decode(file_get_contents($keyFilePath), true)
        ]);
    }

    /**
     * @param       $file string|\yii\web\UploadedFile
     * @return bool|string
     */
    public function upload($file, $preserveFileName = false, $fileName = null)
    {
        /** @var StorageClient $storage */
        $storage = $this->client;

        $bucket = $storage->bucket($this->bucket);

        $fileObj = File::create($file);

        //dd($fileInstance);

        $filename = implode('.', [
            date('d') . Yii::$app->security->generateRandomString(),
            $fileObj->getExtension()
        ]);
        $filePath = implode('/', [1, date('mY'), $filename]);

        // Using Predefined ACLs to manage object permissions, you may
        // upload a file and give read access to anyone with the URL.
        $bucket->upload(
            fopen($file->tempName, 'r'),
            [
                'name'          => $filePath,
                'predefinedAcl' => 'publicRead'
            ]
        );

        return $filePath;
    }

    /**
     * Download an object from Cloud Storage and save it as a local file.
     *
     * @param string $bucketName  the name of your Google Cloud bucket.
     * @param string $objectName  the name of your Google Cloud object.
     * @param string $destination the local destination to save the encrypted object.
     *
     */
    function download_object($objectName, $destination)
    {
        /** @var StorageClient $storage */
        $storage = $this->client;

        $bucket = $storage->bucket($this->bucket);
        $object = $bucket->object($objectName);
        $object->downloadToFile($destination);

        return true;
    }

    /**
     * Move an object to a new name and/or bucket.
     *
     * @param string $bucketName    the name of your Cloud Storage bucket.
     * @param string $objectName    the name of your Cloud Storage object.
     * @param string $newBucketName the destination bucket name.
     * @param string $newObjectName the destination object name.
     *
     * @return void
     */
    function move_object($bucketName, $objectName, $newBucketName, $newObjectName)
    {
        $storage = new StorageClient();
        $bucket = $storage->bucket($bucketName);
        $object = $bucket->object($objectName);
        $object->copy($newBucketName, ['name' => $newObjectName]);
        $object->delete();
        printf('Moved gs://%s/%s to gs://%s/%s' . PHP_EOL,
            $bucketName,
            $objectName,
            $newBucketName,
            $newObjectName);
    }

    /**
     * Copy an object to a new name and/or bucket.
     *
     * @param string $bucketName    the name of your Cloud Storage bucket.
     * @param string $objectName    the name of your Cloud Storage object.
     * @param string $newBucketName the destination bucket name.
     * @param string $newObjectName the destination object name.
     * @return void
     */
    function copy_object($bucketName, $objectName, $newBucketName, $newObjectName)
    {
        $storage = new StorageClient();
        $bucket = $storage->bucket($bucketName);
        $object = $bucket->object($objectName);
        $object->copy($newBucketName, ['name' => $newObjectName]);
        printf('Copied gs://%s/%s to gs://%s/%s' . PHP_EOL,
            $bucketName, $objectName, $newBucketName, $newObjectName);
    }

    /**
     * List object metadata.
     *
     * @param string $bucketName the name of your Cloud Storage bucket.
     * @param string $objectName the name of your Cloud Storage object.
     *
     * @return boolean
     */
    function object_metadata($objectName)
    {
        /** @var StorageClient $storage */
        $storage = $this->client;
        $bucket = $storage->bucket($this->bucket);
        $object = $bucket->object($objectName);
        $info = $object->info();
        printf('Blob: %s' . PHP_EOL, $info['name']);
        printf('Bucket: %s' . PHP_EOL, $info['bucket']);
        printf('Storage class: %s' . PHP_EOL, $info['storageClass']);
        printf('ID: %s' . PHP_EOL, $info['id']);
        printf('Size: %s' . PHP_EOL, $info['size']);
        printf('Updated: %s' . PHP_EOL, $info['updated']);
        printf('Generation: %s' . PHP_EOL, $info['generation']);
        printf('Metageneration: %s' . PHP_EOL, $info['metageneration']);
        printf('Etag: %s' . PHP_EOL, $info['etag']);
        printf('Crc32c: %s' . PHP_EOL, $info['crc32c']);
        printf('MD5 Hash: %s' . PHP_EOL, $info['md5Hash']);
        printf('Content-type: %s' . PHP_EOL, $info['contentType']);
        if (isset($info['metadata'])) {
            printf('Metadata: %s', print_r($info['metadata'], true));
        }

        dd('object');

        return true;
    }

    /**
     * Delete an object.
     *
     * @param string $bucketName the name of your Cloud Storage bucket.
     * @param string $objectName the name of your Cloud Storage object.
     * @param array  $options
     *
     */
    function delete_object($objectName, $options = [])
    {
        /** @var StorageClient $storage */
        $storage = $this->client;

        $bucket = $storage->bucket($this->bucket);
        $object = $bucket->object($objectName);
        //Check Object exits
        if ($object->exists()) {
            $object->delete();
            return true;
        }

        return false;
    }
}