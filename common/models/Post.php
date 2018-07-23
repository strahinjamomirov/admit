<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer       $id
 * @property string        $author_ip
 * @property string        $content
 * @property string        $date
 * @property string        $modified
 * @property integer       $comment_count
 * @property integer       $comment_enabled
 * @property integer       $views_count
 * @property integer       $likes
 * @property integer       $dislikes
 * @property integer       $featured
 * @property integer       $is_enabled
 *
 * @property PostComment[] $postComments
 *
 */
class Post extends ActiveRecord
{
    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_CREATE = 'create';

    public $verifyCode;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required', 'message' => 'Confession can not be empty!'],
            [['comment_count', 'views_count', 'featured', 'comment_enabled'], 'integer'],
            [['content'], 'string', 'length' => [15, 1000]],
            [['date', 'modified'], 'safe'],
            [['author_ip'], 'string', 'max' => 100],
            ['comment_count', 'default', 'value' => 0],
            ['comment_enabled', 'default', 'value' => 1],
            ['is_enabled', 'default', 'value' => 1],
            ['views_count', 'default', 'value' => 0],
            ['likes', 'default', 'value' => 0],
            ['dislikes', 'default', 'value' => 0],
            ['featured', 'default', 'value' => 0],
            ['verifyCode', 'captcha']
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['content'],
            self::SCENARIO_CREATE => ['content', 'verifyCode'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'              => Yii::t('app', 'ID'),
            'author_ip'       => Yii::t('app', 'Author'),
            'content'         => Yii::t('app', 'Content'),
            'date'            => Yii::t('app', 'Date'),
            'comment_count'   => Yii::t('app', 'Comment Count'),
            'comment_enabled' => Yii::t('app', 'Comment Enabled'),
            'is_enabled'      => Yii::t('app', 'Enabled'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostComments()
    {
        return $this->hasMany(PostComment::class, ['post_id' => 'id']);
    }

    /**
     * Get comment status as array
     */
    public function getBooleanStatuses()
    {
        return [
            0 => 'No',
            1 => 'Yes',
        ];
    }

    /**
     * @param string $title
     * @param array  $options
     *
     * @return string
     */
    public function getNextPostLink($title = '{title}', $options = [])
    {
        if ($nextPost = $this->getNextPost()) {
            $title = preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($nextPost) {
                $attribute = $matches[1];

                return $nextPost->{$attribute};
            }, $title);

            return Html::a($title, $nextPost->url, $options);
        }

        return '';
    }

    /**
     *
     * @return array|null|Post
     */
    public function getNextPost()
    {
        /* @var $query \yii\db\ActiveQuery */
        $query = static::find()
            ->from(['post' => $this->tableName()])
            ->andWhere(['>', 'post.id', $this->id])
            ->orderBy(['post.id' => SORT_ASC]);

        return $query->one();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @param string $title
     * @param array  $options
     *
     * @return string
     */
    public function getPrevPostLink($title = '{title}', $options = [])
    {
        if ($prevPost = $this->getPrevPost()) {
            $title = preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($prevPost) {
                $attribute = $matches[1];

                return $prevPost->{$attribute};
            }, $title);

            return Html::a($title, $prevPost->url, $options);
        }

        return '';
    }

    /**
     *
     * @return array|null|Post
     */
    public function getPrevPost()
    {
        /* @var $query \yii\db\ActiveQuery */
        $query = static::find()
            ->from(['post' => $this->tableName()])
            ->andWhere(['<', 'post.id', $this->id])
            ->orderBy(['post.id' => SORT_DESC]);

        return $query->one();
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->date = date('Y-m-d H:i:s');
            $this->modified = date('Y-m-d H:i:s');
            return true;
        }

        return false;
    }
}
