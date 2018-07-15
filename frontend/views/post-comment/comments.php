<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */
use common\models\Option;
use frontend\widgets\PostComment;
/* @var $post common\models\Post */
/* @var $comment common\models\PostComment */
?>
<div id="comment-view">

    <?php if ($post->comment_count): ?>
        <h2 class="comment-title">
            <?= Yii::t('app', '{comment_count} {comment_word} on {title}', [
                'comment_count' => $post->comment_count,
                'comment_word' => $post->comment_count > 1 ? 'Replies' : 'Reply'
            ]) ?>

        </h2>

        <?= PostComment::widget(['model' => $post, 'id' => 'comments']) ?>

    <?php endif ?>

    <?= $this->render('_form', ['model' => $comment, 'post' => $post]) ?>

</div>