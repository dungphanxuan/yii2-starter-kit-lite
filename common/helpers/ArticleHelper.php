<?php
namespace common\helpers;

use Yii;
use common\models\Article;
use yii\helpers\Inflector;

class ArticleHelper extends Inflector
{
    public static function getDetail($id, $update = false)
    {
        $cacheKey = CACHE_ARTICLE_ITEM . $id;
        $data = dataCache()->get($cacheKey);

        if ($data === false or $update) {
            $data = [];
            /** @var Article $model */
            $model = Article::find()->published()->where(['id' => $id])->one();
            if ($model) {
                $data['id'] = $model->id;
                $data['aid'] = $model->aid;
                $data['title'] = $model->title;
                $data['body'] = $model->body;
                $data['category_name'] = $model->category->title;
                $data['thumbnail_image'] = $model->thumbnail_base_url . '/' . $model->thumbnail_path;

                $dataImage = [];
                if ($model->attachments) {
                    foreach ($model->attachments as $itemAtt) {
                        $dataImage[] = $itemAtt['base_url'] . '/' . $itemAtt['path'];
                    }
                }
                $data['attachments'] = $dataImage;

                $appFormat = \Yii::$app->formatter;
                $data['published_at'] = $model->published_at ? $appFormat->asDatetime($model->published_at) : '';
                $data['update_time'] = $model->updated_at ? $appFormat->asDatetime($model->updated_at) : '';
                $data['updated'] = $model->updated_at ? $model->updated_at : '';

            }

            /*Set cache*/
            dataCache()->set($cacheKey, $data, 600);
        }
        return $data;
    }

    /*
     * Random Article ID
     * */
    public static function getRandomID()
    {
        $articleId = Yii::$app->getSecurity()->generateRandomString(16);
        $article = Article::findOne(['aid' => $articleId,]);
        if (!$article) {
            return $articleId;
        }
        return ArticleHelper::getRandomID();
    }

}