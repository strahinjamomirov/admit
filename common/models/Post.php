<?php
/**
 * @link      http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer            $id
 * @property string             $content
 * @property string             $date
 * @property string             $modified
 * @property string             $status
 * @property string             $slug
 * @property string             $comment_status
 * @property integer            $comment_count
 * @property integer            $views_count
 * @property integer            $featured
 * @property string             $url
 *
 * @property PostComment[]      $postComments
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since  0.1.0
 */
class Post extends ActiveRecord {

	const COMMENT_STATUS_OPEN = 'open';
	const COMMENT_STATUS_CLOSE = 'close';
	const STATUS_PUBLISH = 'publish';
	const STATUS_PRIVATE = 'private';
	const STATUS_DRAFT = 'draft';
	const STATUS_TRASH = 'trash';
	const STATUS_REVIEW = 'review';

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%post}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
            [ [ 'content' ], 'required' ],
			[ [ 'comment_count', 'views_count', 'featured' ], 'integer' ],
			[ [ 'content' ], 'string' ],
			[ [ 'date', 'modified'], 'safe' ],
			[ [ 'status', 'comment_status' ], 'string', 'max' => 20 ],
			[ [ 'slug' ], 'string', 'max' => 255 ],
			[ 'comment_status', 'in', 'range' => [ self::COMMENT_STATUS_OPEN, self::COMMENT_STATUS_CLOSE ] ],
			[ 'comment_status', 'default', 'value' => self::COMMENT_STATUS_CLOSE ],
			[ 'comment_count', 'default', 'value' => 0 ],
			[ 'views_count', 'default', 'value' => 0 ],
			[ 'featured', 'default', 'value' => 0 ],
			[
				'status',
				'in',
				'range' => [
					self::STATUS_PUBLISH,
					self::STATUS_DRAFT,
					self::STATUS_PRIVATE,
					self::STATUS_REVIEW,
					self::STATUS_TRASH,
				],
			],
			[ 'status', 'default', 'value' => self::STATUS_PUBLISH ],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id'             => Yii::t( 'cms', 'ID' ),
			'content'        => Yii::t( 'cms', 'Content' ),
			'date'           => Yii::t( 'cms', 'Date' ),
			'status'         => Yii::t( 'cms', 'Status' ),
			'comment_status' => Yii::t( 'cms', 'Comment Status' ),
			'comment_count'  => Yii::t( 'cms', 'Comment Count' ),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPostComments() {
		return $this->hasMany( PostComment::className(), [ 'post_id' => 'id' ] );
	}

	/**
	 * Get post status as array.
	 *
	 * @return array
	 */
	public function getPostStatuses() {
		return [
			self::STATUS_PUBLISH => Yii::t( 'cms', 'Publish' ),
			self::STATUS_DRAFT   => Yii::t( 'cms', 'Draft' ),
			self::STATUS_PRIVATE => Yii::t( 'cms', 'Private' ),
			self::STATUS_TRASH   => Yii::t( 'cms', 'Trash' ),
			self::STATUS_REVIEW  => Yii::t( 'cms', 'Review' ),
		];
	}

	/**
	 * Get comment status as array
	 */
	public function getCommentStatuses() {
		return [
			self::COMMENT_STATUS_OPEN  => Yii::t( 'cms', 'Open' ),
			self::COMMENT_STATUS_CLOSE => Yii::t( 'cms', 'Close' ),
		];
	}

	/**
	 * Get comment status as array
	 */
	public function getBooleanStatuses() {
		return [
			0 => 'No',
			1 => 'Yes',
		];
	}

	/**
	 *
	 * @return array|null|Post
	 */
	public function getNextPost() {
		/* @var $query \yii\db\ActiveQuery */
		$query = static::find()
		               ->from( [ 'post' => $this->tableName() ] )
		               ->andWhere( [ '>', 'post.id', $this->id ] )
		               ->andWhere( [ 'status' => 'publish' ] )
		               ->orderBy( [ 'post.id' => SORT_ASC ] );

		return $query->one();
	}

	/**
	 * @param string $title
	 * @param array  $options
	 *
	 * @return string
	 */
	public function getNextPostLink( $title = '{title}',  $options = [] ) {
		if ( $nextPost = $this->getNextPost() ) {
			$title = preg_replace_callback( '/\\{([\w\-\/]+)\\}/', function ( $matches ) use ( $nextPost ) {
				$attribute = $matches[1];

				return $nextPost->{$attribute};
			}, $title );

			return Html::a( $title, $nextPost->url, $options );
		}

		return '';
	}

	/**
	 *
	 * @return array|null|Post
	 */
	public function getPrevPost() {
		/* @var $query \yii\db\ActiveQuery */
		$query = static::find()
		               ->from( [ 'post' => $this->tableName() ] )
		               ->andWhere( [ '<', 'post.id', $this->id ] )
		               ->andWhere( [ 'status' => 'publish' ] )
		               ->orderBy( [ 'post.id' => SORT_DESC ] );

		return $query->one();
	}

	/**
	 * @param string $title
	 * @param array  $options
	 *
	 * @return string
	 */
	public function getPrevPostLink( $title = '{title}', $options = [] ) {
		if ( $prevPost = $this->getPrevPost() ) {
			$title = preg_replace_callback( '/\\{([\w\-\/]+)\\}/', function ( $matches ) use ( $prevPost ) {
				$attribute = $matches[1];

				return $prevPost->{$attribute};
			}, $title );

			return Html::a( $title, $prevPost->url, $options );
		}

		return '';
	}


	/**
	 * @inheritdoc
	 */
	public function beforeSave( $insert ) {
		if ( parent::beforeSave( $insert ) ) {
			$this->modified = date( 'Y-m-d H:i:s' );
			return true;
		}

		return false;
	}
}