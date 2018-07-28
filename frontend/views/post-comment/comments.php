<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */
use frontend\widgets\PostComment;
/* @var $post common\models\Post */
/* @var $comment common\models\PostComment */

?>
<div id="comment-view">

    <?php if ($post->comment_count): ?>

        <?= PostComment::widget(['model' => $post, 'id' => 'comments']) ?>

    <?php endif ?>

    <div class="confession">
        <?= $this->render('_form', ['model' => $comment, 'post' => $post]) ?>
    </div>

</div>
