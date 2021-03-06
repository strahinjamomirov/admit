<?php
namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%post_comment}}".
 *
 * @property integer $post_id
 *
 * @property Post $commentPost
 */
class PostComment extends BaseComment
{
    /**
     * @var string
     */
    public $post_title;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['post_id', 'required'],
            ['post_id', 'integer'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'post_id' => Yii::t('app', 'Comment to')
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }
}
