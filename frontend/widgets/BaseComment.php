<?php
/**
 * @link      http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/**
 * Class BaseComment
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since  0.1.0
 */
abstract class BaseComment extends Widget
{
    /**
     * @var string
     */
    public $tag = 'ul';
    /**
     * @var
     */
    public $model;
    /**
     * @var
     */
    public $enableThreadComments;
    /**
     * @var
     */
    public $maxDepth;
    /**
     * @var
     */
    public $commentOrder;
    /**
     * @var int
     */
    public $avatarSize = 48;
    /**
     * @var array
     */
    public $options = ['class' => 'comments'];
    /**
     * @var array
     */
    public $childOptions = ['class' => 'child'];
    /**
     * @var array
     */
    public $itemOptions = ['class' => 'media'];
    /**
     * @var
     */
    protected $pageSize;
    /**
     * @var
     */
    protected $pages;
    /**
     * @var
     */
    protected $comments;
    /**
     * @var
     */
    protected $tagItem;

    /**
     * @inheritdoc
     */
    public function init()
    {
        switch ($this->tag) {
            case 'div':
                $this->tagItem = 'div';
                break;
            case 'ul':
            case 'li':
                $this->tagItem = 'li';
                break;
        }
        if (!$this->pageSize) {
//            $this->pageSize = Option::get('comments_per_page');
            $this->pageSize = 10;
        }
        if (!$this->maxDepth) {
//            $this->maxDepth = Option::get('thread_comments_depth');
            $this->maxDepth = 2;
        }
        if (!$this->commentOrder) {
            $this->commentOrder = SORT_DESC;
            //$this->commentOrder = Option::get('comment_order') === 'asc' ? SORT_ASC : SORT_DESC;
        }
        if (!$this->enableThreadComments) {
            $this->enableThreadComments = 1;
//            $this->enableThreadComments = Option::get('thread_comments');
        }
        Html::addCssClass($this->itemOptions, 'comment');
        $this->setComments();
    }

    /**
     * Set comment model and pagination.
     */
    protected function setComments()
    {
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->comments) {
            Pjax::begin();
            echo Html::beginTag($this->tag, ArrayHelper::merge(['id' => $this->id], $this->options));
            $this->renderComments($this->comments);
            echo Html::endTag($this->tag);
            echo Html::beginTag('nav', ['class' => 'comment-pagination']);
            echo LinkPager::widget([
                'pagination'           => $this->pages,
                'activePageCssClass'   => 'active',
                'disabledPageCssClass' => 'disabled',
                'options'              => [
                    'class' => 'pagination',
                ],
            ]);
            echo Html::endTag('nav');
            Pjax::end();
        }
    }

    /**
     * @param     $comments
     * @param int $depth
     */
    protected function renderComments($comments, $depth = 0)
    {
        foreach ($comments as $comment) {
            echo Html::beginTag($this->tagItem, $this->itemOptions);
            $this->displayComment($comment, $depth);
            if ($comment->child) {
                $depth++;
                if ($depth <= $this->maxDepth && $this->enableThreadComments) {
                    echo Html::beginTag($this->tag, $this->childOptions);
                    $this->renderComments($comment->child, $depth);
                    echo Html::endTag($this->tag);
                }
                $depth--;
            }
            echo Html::endTag($this->tagItem);
        }
    }

    /**
     * @param \common\models\BaseComment $comment
     * @param int                        $depth
     *
     * @throws \Exception
     */
    protected function displayComment($comment, $depth = 0)
    {
        echo Html::beginTag('div', [
            'id'    => 'comment-' . $comment->id,
            'class' => $comment->child ? 'parent depth-' . $depth : 'depth-' . $depth,
        ]);
        ?>

        <div class="media-body comment-body">
            <div class="row">
                <div class="col-md-12 comment-content">
                    <?= $comment->content ?>
                </div>
            </div>
            <div class="row font-change">
                <div class="col-md-6">
                    <?= $comment->author ? $comment->author : \Yii::t('app', 'Anonymous') ?>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <?php if ($depth < $this->maxDepth && $this->enableThreadComments): ?>

                        <div class="col-md-6">
                                <?php if ($comment->child): $numberOfSubComments = count($comment->child); ?>
                                <?= Html::a(Html::img('/images/reply.png'), '#', [
                                    'class'   => 'comment-reply-link link-color',
                                    'value'   => Url::to(['post/post-comment-reply', 'parent' => $comment->id]),
                                    'data-id' => $comment->id,
                                ]); ?>
                                <?= $numberOfSubComments ?>
                            <?php endif; ?>
                                <?= Html::a('Reply ' . Html::img('/images/reply2.png'), '#', [
                                    'class'   => 'comment-reply-link link-color',
                                    'value'   => Url::to(['post/post-comment-reply', 'parent' => $comment->id]),
                                    'data-id' => $comment->id,
                                ]); ?>
                        </div>


                        <div class="col-md-2">
                            <div class="praise-comment"
                                 data-id="<?= $comment->id ?>">
                                Like
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="condemn-comment"
                                 data-id="<?= $comment->id ?>">
                                Dislike
                            </div>
                        </div>
                        <div class="col-md-2">
                            <?php
                            $numberOfLikes = $comment->likes;
                            $numberOfDislikes = $comment->dislikes;

                            $number = $numberOfLikes - $numberOfDislikes;

                            ?>
                            <div id="number-of-comments-<?= $comment->id ?>"><?= $number ?></div>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

        </div>
        <?php
        echo Html::endTag('div');
    }

    /**
     * Get comment children.
     *
     * @param int $id
     */
    protected
    function getChildren(
        $id
    ) {
    }
}