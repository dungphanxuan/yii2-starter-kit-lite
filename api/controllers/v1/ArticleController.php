<?php
namespace api\controllers\v1;

use api\controllers\ApiController;
use api\models\search\ArticleSearch;
use common\helpers\ArticleHelper;
use common\helpers\DataHelper;
use common\models\Article;
use Yii;
use yii\data\ActiveDataProvider;


/**
 * Class ArticleController
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends ApiController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'index'  => ['get'],
                    'view'   => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'put', 'post'],
                    'like' => ['post'],
                    'un-like' => ['post'],
                ],
            ],
        ];
    }
    /**
     * @return string
     */
    public function actionIndex()
    {
        $get_order = getParam('order', '');

        $articleData = ArticleHelper::getAll($this->app_id);
        $this->msg = 'Article index!';
        $this->data = $articleData;
    }

    /**
     * @param $id
     * @return string
     */
    public function actionCreate()
    {
        $model = new Article();
    }

    /**
     * @param $id
     * @return string
     * @throws /NotFoundHttpException
     */
    public function actionView()
    {
        $get_id = getParam('id', '');
        if (empty($get_id)) {
            $this->msg = "Thiếu thông tin ID";
            $this->code = 422;
        }else{
            $articleDetail = ArticleHelper::getDetail($get_id);
            $model = Article::findOne($get_id);
            $model->updateCounters(['view_count' => 1]);
            $this->msg = 'Article detail!';
            $this->data = $articleDetail;
        }
    }

    /**
     * @param $id
     * @return string
     * @throws /NotFoundHttpException
     */
    public function actionLike(){
        $get_id = postParam('id', '');
        if (empty($get_id)) {
            $this->status = 0;
            $this->msg = "Required Article ID";
        }else{
            $articleDetail = ArticleHelper::getDetail($get_id);
            if (isset($articleDetail)) {
                $cache_key = REDIS_ARTICLE_LIKE.$this->uid;
                redis()->zadd($cache_key, time(), $get_id);

                $this->code = 200;
                $this->msg = "Like success!";
            }else {
                $this->code = 404;
                $this->msg = "Article not found!";
            }
        }
    }

    /**
     * @param $id
     * @return string
     * @throws /NotFoundHttpException
     */
    public function actionUnLike(){
        $get_id = postParam('id', '');
        if (empty($get_id)) {
            $this->status = 0;
            $this->msg = "Required Article ID";
        }else{
            $articleDetail = ArticleHelper::getDetail($get_id);
            if (isset($articleDetail)) {
                $cache_key = REDIS_ARTICLE_LIKE.$this->uid;
                redis()->zrem($cache_key, time(), $get_id);

                $this->code = 200;
                $this->msg = "Unlike success!";
            }else {
                $this->code = 404;
                $this->msg = "Article not found!";
            }
        }

    }

}
