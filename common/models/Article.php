<?php

namespace common\models;

use common\models\query\ArticleQuery;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property string $view
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property array $attachments
 * @property integer $author_id
 * @property integer $updater_id
 * @property integer $category_id
 * @property integer $status
 * @property integer $published_at
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $author
 * @property User $updater
 * @property ArticleCategory $category
 * @property ArticleAttachment[] $articleAttachments
 */
class Article extends ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;

    /**
     * @var array
     */
    public $attachments;

    /**
     * @var array
     */
    public $thumbnail;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @return ArticleQuery
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }

    /**
     * @return array statuses list
     */
    public static function statuses()
    {
        return [
            self::STATUS_DRAFT => Yii::t('common', 'Draft'),
            self::STATUS_PUBLISHED => Yii::t('common', 'Published'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'immutable' => true
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'attachments',
                'multiple' => true,
                'uploadRelation' => 'articleAttachments',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'orderAttribute' => 'order',
                'typeAttribute' => 'type',
                'sizeAttribute' => 'size',
                'nameAttribute' => 'name',
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'thumbnail',
                'pathAttribute' => 'thumbnail_path',
                'baseUrlAttribute' => 'thumbnail_base_url'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'body', 'category_id'], 'required'],
            [['slug'], 'unique'],
            [['body'], 'string'],
            [
                ['published_at'],
                'default',
                'value' => function () {
                    return date(DATE_ISO8601);
                }
            ],
            [['published_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['category_id'], 'exist', 'targetClass' => ArticleCategory::class, 'targetAttribute' => 'id'],
            [['status'], 'integer'],
            [['slug', 'thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
            [['title'], 'string', 'max' => 512],
            [['view'], 'string', 'max' => 255],
            [['attachments', 'thumbnail'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'slug' => Yii::t('common', 'Slug'),
            'title' => Yii::t('common', 'Title'),
            'body' => Yii::t('common', 'Body'),
            'view' => Yii::t('common', 'Article View'),
            'thumbnail' => Yii::t('common', 'Thumbnail'),
            'category_id' => Yii::t('common', 'Category'),
            'status' => Yii::t('common', 'Published'),
            'published_at' => Yii::t('common', 'Published At'),
            'created_by' => Yii::t('common', 'Author'),
            'updated_by' => Yii::t('common', 'Updater'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::class, ['id' => 'updater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::class, ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleAttachments()
    {
        return $this->hasMany(ArticleAttachment::class, ['article_id' => 'id']);
    }

    /*
     * Copy Model Data
     * */
    public function copyModel($id)
    {
        $cModel = Article::find()->published()->where(['id' => $id])->one();
        if ($cModel) {
            $data = $cModel->attributes;
            $this->setAttributes($data);
            //Copy thumbnail
            if ($cModel->thumbnail) {
                if (fileStorage()->getFilesystem()->has($cModel->thumbnail['path'])) {
                    $this->thumbnail = $cModel->thumbnail;
                    $copyImage = "1/cp_" . Yii::$app->security->generateRandomString(20) . date('YmdHim') . ".jpg";
                    $this->thumbnail['path'] = $copyImage;
                    $this->thumbnail_path = $copyImage;
                    fileSystem()->copy($cModel->thumbnail['path'], $copyImage);
                }
            }
            //Copy attachments
            $this->attachments = $cModel->attachments;
            foreach ($cModel->articleAttachments as $key => $img) {
                if (fileStorage()->getFilesystem()->has($cModel->attachments[$key]['path'])) {
                    $new_filename = "1/cp_" . $key . "_" . date('YmdHim') . time() . ".jpg";
                    fileSystem()->copy($cModel->attachments[$key]['path'], $new_filename);
                    $this->attachments[$key]['path'] = $new_filename;
                }
            }

            $this->slug = '';
        }
    }


    /*
     * Show Image Thumbnail
     * @return string
     * */
    public function getImgThumbnail($type = 1, $q = 75, $w = null, $h = null)
    {
        $url = '';
        $hasPath = fileSystem()->has($this->thumbnail_path);
        $path = 'images/logo_square.png';
        if ($this->thumbnail_path && $hasPath) {
            $path = $this->thumbnail_path;
        }
        //dd($path);
        switch ($type) {
            case 1:
                $url = $this->thumbnail_base_url . '/' . $path;
                break;
            case 2:
                $signConfig = [
                    'glide/index',
                    'path' => $path,
                    'fit' => 'crop'
                ];
                if ($w) {
                    $signConfig['w'] = $w;
                }
                if ($h) {
                    $signConfig['h'] = $h;
                }
                $url = Yii::$app->glide->createSignedUrl($signConfig);
                break;
            default:
                $signConfig = [
                    'glide/index',
                    'path' => $path,
                    'w' => '480',
                    'h' => '240',
                    'fit' => 'crop'
                ];

                $url = Yii::$app->glide->createSignedUrl($signConfig);
        }


        //dd($url);
        return $url;
    }

}
