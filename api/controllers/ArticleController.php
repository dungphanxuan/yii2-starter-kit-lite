<?php

namespace api\controllers;

use common\helpers\ArticleHelper;
use common\models\Article;
use yii\data\ArrayDataProvider;
use yii\db\Query;

class ArticleController extends ApiController
{

    /**
     * Get List Article
     *
     * @param integer $flag Last update time
     * @return array Articles
     */
    public function actionIndex()
    {
        $timeFlag = getParam('flag', null);
        $query = Article::find();

        if ($timeFlag) {
            if (isValidTimeStamp($timeFlag)) {
                $query->where(['>', 'updated_at', $timeFlag]);
            }
        }
        /*Add order by updated*/
        $query->orderBy('updated_at DESC');

        $provider = new ArrayDataProvider([
            'allModels' => $query->all(),
            'sort' => [
                'attributes' => ['id'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $articles = $provider->getModels();
        $data = [];

        $q = new Query();
        $maxUpdated = $q->from(Article::tableName())->max('updated_at');

        $data['total'] = count($articles);
        $data['last_update'] = $maxUpdated;
        $data_item = [];
        foreach ($articles as $articleItem) {
            $data_item[] = ArticleHelper::getDetail($articleItem->id, true);;
        }

        $data['items'] = $data_item;

        $this->msg = 'List Article';
        $this->data = $data;

    }

    /**
     * Get Article Detail
     *
     * @param integer $id Article ID
     * @return array Article detail
     */
    public function actionView()
    {
        $getId = getParam('aid', null);
        if ($getId) {
            $model = Article::find()->published()->where(['aid' => $getId])->one();
            if ($model) {
                $data = ArticleHelper::getDetail($model->id);
                $this->msg = 'Article detail';
                $this->data = $data;
            } else {
                $this->code = 404;
                $this->msg = 'Article Not Found';
            }

        } else {
            $this->code = 422;
            $this->msg = 'Missing Article ID ';
        }
    }
}
