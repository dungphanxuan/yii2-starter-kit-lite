<?php

namespace common\models;

/**
 * This is the model class for table "tbl_article_pickup".
 *
 * @property integer $id
 * @property integer $article_id
 * @property integer $sort_number
 */
class ArticlePickup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_article_pickup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id'], 'required'],
            [['article_id', 'sort_number'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'article_id'  => 'Article',
            'sort_number' => 'Sort Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::class, ['id' => 'article_id']);
    }

}
