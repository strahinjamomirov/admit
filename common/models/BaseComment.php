<?php
/**
 * @link      http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%post_comment}}".
 *
 * @property integer $id
 * @property string  $author
 * @property string  $ip
 * @property string  $date
 * @property string  $content
 * @property integer $parent
 * @property integer $likes
 * @property integer $dislikes
 * @property integer $is_enabled
 * @property integer $is_reported
 * @property integer $number_of_reports
 *
 * @author  Agiel K. Saputra <13nightevil@gmail.com>
 * @since   0.1.0
 */
abstract class BaseComment extends ActiveRecord
{
    /**
     * @var BaseComment[]
     */
    public $child;

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['reply'] = $scenarios['default'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['content'],
                'required'
            ],
            [['parent'], 'integer'],
            ['parent', 'default', 'value' => 0],
            [['author', 'content'], 'string'],
            ['date', 'safe'],
            [['ip'], 'string', 'max' => 100],
            ['likes', 'default', 'value' => 0],
            ['dislikes', 'default', 'value' => 0],
            ['is_enabled', 'default', 'value' => 1],
            ['is_reported', 'default', 'value' => 0],
            ['number_of_reports', 'default', 'value' => 0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => Yii::t('app', 'ID'),
            'author'            => Yii::t('app', 'Name'),
            'ip'                => Yii::t('app', 'IP'),
            'date'              => Yii::t('app', 'Date'),
            'content'           => Yii::t('app', 'Content'),
            'parent'            => Yii::t('app', 'Parent'),
            'likes'             => Yii::t('app', 'Likes'),
            'dislikes'          => Yii::t('app', 'Dislikes'),
            'is_enabled'        => Yii::t('app', 'Enabled'),
            'is_reported'       => Yii::t('app', 'Report'),
            'number_of_reports' => Yii::t('app', 'NUmber Of Reports'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }


    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->ip = $_SERVER['REMOTE_ADDR'];
                $this->date = date('Y-m-d H:i:s');
            }

            return true;
        }

        return false;
    }
}
