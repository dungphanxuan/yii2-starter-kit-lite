<?php

namespace backend\controllers;

use backend\models\search\ArticleSearch;
use common\helpers\ArticleHelper;
use common\models\Article;
use common\models\ArticleCategory;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post']
                ]
            ]
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $params = Yii::$app->request->queryParams;

        //Filter Category
        $getCategory = getParam('category_id', null);
        if ($getCategory) {
            $params['ArticleSearch']['category_id'] = $getCategory;
        }
        $dataProvider = $searchModel->search($params);
        $dataProvider->sort = [
            'defaultOrder' => ['published_at' => SORT_DESC]
        ];

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'categories'   => ArticleCategory::find()->active()->all(),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $id = getParam('id', null);
        $model = new Article();
        //Copy data
        if ($id) {
            /** @var Article $eModel */
            $eModel = Article::find()->published()->where(['id' => $id])->one();
            if ($eModel) {
                $model->copyModel($id);
            } else {
                throw new NotFoundHttpException('Article does not exist.');
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            ArticleHelper::getDetail($model->id);

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model'      => $model,
                'categories' => ArticleCategory::find()->active()->all(),
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            ArticleHelper::getDetail($model->id);

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model'      => $model,
                'categories' => ArticleCategory::find()->active()->all(),
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
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

    public function actionAjaxDelete()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (isAjax()) {
            $dataPost = $_POST;
            $dataId = isset($dataPost['ids']) ? $dataPost['ids'] : [];
            foreach ($dataId as $item) {
                /** @var Article $mode */
                $mode = Article::find()->where(['id' => $item])->one();
                if ($mode) {
                    $mode->status = 0;
                    $mode->save();
                }
            }
            $res = [
                'body'    => 'Sucess',
                'success' => true,
            ];

            return $res;
        }
        $res = [
            'body'    => 'Not allow',
            'success' => false,
        ];

        return $res;
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
