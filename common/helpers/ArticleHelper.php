<?php
namespace common\helpers;

use common\models\Article;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\Json;

class ArticleHelper extends Inflector
{
    public static function getDetail($id, $update = false)
    {
        $cacheKey = CACHE_ARTICLE_ITEM . $id;
        $data = dataCache()->get($cacheKey);

        if ($data === false or $update) {
            $data = [];
            /** @var Article $mode */
            $mode = Article::find()->published()->where(['id' => $id])->one();

            //php_dump($mode->attributes);
            $data = [];
            $data['id'] = $mode->id;
            $data['title'] = $mode->title;
            $data['body'] = $mode->body;
            $data['category_name'] = $mode->category->title;
            $data['thumbnail_image'] = $mode->thumbnail_base_url . '/' . $mode->thumbnail_path;

            $dataImage = [];
            if ($mode->attachments) {
                foreach ($mode->attachments as $itemAtt) {
                    $dataImage[] = $itemAtt['base_url'] . '/' . $itemAtt['path'];
                }
            }
            $data['attachments'] = $dataImage;

            $appFormat =  \Yii::$app->formatter;
            $data['published_at'] = $mode->published_at ? $appFormat->asDatetime($mode->published_at) : '';
            $data['update_time'] = $mode->updated_at ? $appFormat->asDatetime($mode->updated_at) : '';
            $data['updated'] = $mode->updated_at ? $mode->updated_at : '';

            /*Set cache*/
            dataCache()->set($cacheKey, $data, 600);
        }
        return $data;
    }

}