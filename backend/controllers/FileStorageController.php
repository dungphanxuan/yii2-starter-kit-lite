<?php

namespace backend\controllers;

use backend\modules\system\models\search\FileStorageItemSearch;
use common\components\filesystem\actions\FilestackDeleteAction;
use common\components\filesystem\actions\FilestackUploadAction;
use common\components\filesystem\actions\StorageDeleteAction;
use common\components\filesystem\actions\StorageUploadAction;
use common\models\FileStorageItem;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * FileStorageController implements the CRUD actions for FileStorageItem model.
 */
class FileStorageController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete'        => ['post'],
                    'upload-delete' => ['delete']
                ]
            ]
        ];
    }


    public function actions()
    {
        return [
            'upload'                  => [
                //'class' => 'trntv\filekit\actions\UploadAction',
                'class'       => 'common\actions\filekit\UploadAction',
                'deleteRoute' => 'upload-delete'
            ],
            'upload-delete'           => [
                'class' => 'trntv\filekit\actions\DeleteAction'
            ],
            'upload-imperavi'         => [
                //'class' => 'trntv\filekit\actions\UploadAction',
                'class'            => 'common\actions\filekit\UploadAction',
                'fileparam'        => 'file',
                'responseUrlParam' => 'filelink',
                'multiple'         => false,
                'disableCsrf'      => true
            ],
            'upload-image'            => [
                'class'            => 'common\actions\filekit\UploadAction',
                'fileparam'        => 'image',
                'responseUrlParam' => 'filelink',
                'multiple'         => false,
                'disableCsrf'      => true
            ],
            'upload-filestack-action' => [
                'class'       => FilestackUploadAction::class,
                'deleteRoute' => 'upload-delete-filestack',
                'base_url'    => 'https://cdn.filestackcontent.com',
            ],
            'upload-storage'          => [
                'class'       => StorageUploadAction::class,
                'deleteRoute' => 'upload-delete-storage',
                'base_url'    => 'https://storage.googleapis.com/yii_bucket',
            ],

            'upload-delete-storage'   => [
                'class' => StorageDeleteAction::class
            ],
            'upload-delete-filestack' => [
                'class' => FilestackDeleteAction::class
            ],
            'upload-delete-gcloud'    => [
                'class'       => 'trntv\filekit\actions\DeleteAction',
                'fileStorage' => 'fileStorageGCloud'
            ],
        ];
    }

    /**
     * Lists all FileStorageItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileStorageItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];
        $components = \yii\helpers\ArrayHelper::map(
            FileStorageItem::find()->select('component')->distinct()->all(),
            'component',
            'component'
        );
        $totalSize = FileStorageItem::find()->sum('size') ?: 0;

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'components'   => $components,
            'totalSize'    => $totalSize
        ]);
    }

    /**
     * Displays a single FileStorageItem model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Deletes an existing FileStorageItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /*
     * Action Upload File For Froala WYSIWYG HTML Editor
     *
     * @param file $file
     *
     * @return file infor
     * */
    public function actionUploadFroala()
    {
        // Get file link
        $fileName = 'file';
        $logoFile = UploadedFile::getInstanceByName($fileName);
        $filePath = Yii::$app->fileStorage->save($logoFile);
        $baseUrl = Yii::$app->fileStorage->baseUrl;
        $res = ['link' => $baseUrl . '/' . $filePath];

        // Response data
        Yii::$app->response->format = Yii::$app->response->format = Response::FORMAT_JSON;

        return $res;
    }

    public function actionFileFroala()
    {
        $dataFileItem = FileStorageItem::find()
            ->limit(10)
            ->orderBy('id desc')
            ->all();
        $dataImage = [];
        /** @var FileStorageItem $item */
        foreach ($dataFileItem as $item) {
            if (Yii::$app->fileStorage->getFilesystem()->has($item->path)) {
                $dataDetail = [];
                $dataDetail['url'] = $item->base_url . '/' . $item->path;
                $dataImage [] = $dataDetail;
            }
        }

        $res = $dataImage;
        // Response data
        Yii::$app->response->format = Yii::$app->response->format = Response::FORMAT_JSON;

        return $res;
    }

    /**
     * Finds the FileStorageItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return FileStorageItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FileStorageItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
