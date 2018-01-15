<?php

namespace common\models;

use common\models\query\ArticleCategoryQuery;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article_category".
 *
 * @property integer         $id
 * @property string          $slug
 * @property string          $title
 * @property integer         $order
 * @property integer         $status
 *
 * @property Article[]       $articles
 * @property ArticleCategory $parent
 */
class ArticleCategory extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;

    /**
     * @var array
     */
    public $thumbnail;

    public $totalArticle;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_category}}';
    }

    /**
     * @return ArticleCategoryQuery
     */
    public static function find()
    {
        return new ArticleCategoryQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class'     => SluggableBehavior::className(),
                'attribute' => 'title',
                'immutable' => true
            ],
            [
                'class'            => UploadBehavior::className(),
                'attribute'        => 'thumbnail',
                'pathAttribute'    => 'thumbnail_path',
                'baseUrlAttribute' => 'thumbnail_base_url'
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 512],
            [['slug'], 'unique'],
            [['slug'], 'string', 'max' => 1024],
            [['status', 'order'], 'integer'],
            ['parent_id', 'exist', 'targetClass' => ArticleCategory::className(), 'targetAttribute' => 'id'],
            [['thumbnail'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('common', 'ID'),
            'slug'         => Yii::t('common', 'Slug'),
            'title'        => Yii::t('common', 'Title'),
            'parent_id'    => Yii::t('common', 'Parent Category'),
            'thumbnail'    => Yii::t('common', 'Thumbnail'),
            'order'        => Yii::t('common', 'Order'),
            'status'       => Yii::t('common', 'Active'),
            'totalArticle' => Yii::t('common', 'Total Article')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasMany(ArticleCategory::className(), ['id' => 'parent_id']);
    }

    /*
    * Get total Article of category
    * @return integer
    * */
    public function getTotal()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id'])->count();
    }

}
