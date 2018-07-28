<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

use common\components\View;
use frontend\widgets\PostComment;
use yii\helpers\Url;

/* @var $post common\models\Post */
/* @var $comment common\models\PostComment */
$this->registerJs("

$('body').on('click', '.praise-comment', function () {
        likeFunctionComment($(this).data('id'));
    });
    $('body').on('click', '.condemn-comment', function () {
        dislikeFunctionComment($(this).data('id'));
    });

");
$this->registerJs("var urlLikeComment = '" . Yii::$app->request->baseUrl . Url::to(['post/like-comment']) . "';",
    View::POS_BEGIN);
$this->registerJs("var urlDislikeComment = '" . Yii::$app->request->baseUrl . Url::to(['post/dislike-comment']) . "';",
    View::POS_BEGIN);
$this->registerJs("var _csrf = '" . Yii::$app->request->getCsrfToken() . "';", View::POS_BEGIN);

$this->registerJs("
    function likeFunctionComment(id) {
        $.ajax({
            url: urlLikeComment,
            type: 'post',
            data: {
                id: id,
                _csrf: _csrf
            },
            success: function (data) {
                var notExisting = data.notExisting;
                if (!notExisting) {
                    $('#number-of-comments-' + data.id).text(data.numberOfLikes);
                }
            }
        });
    }

    function dislikeFunctionComment(id) {
        $.ajax({
            url: urlDislikeComment,
            type: 'post',
            data: {
                id: id,
                _csrf: _csrf
            },
            success: function (data) {
                var notExisting = data.notExisting;
                if (!notExisting) {
                    $('#number-of-comments-' + data.id).text(data.numberOfLikes);
                }
            }
        });
    }", View::POS_END)
?>
<div id="comment-view">

    <?php if ($post->comment_count): ?>

        <?= PostComment::widget(['model' => $post, 'id' => 'comments']) ?>

    <?php endif ?>

    <div class="confession">
        <?= $this->render('_form', ['model' => $comment, 'post' => $post]) ?>
    </div>

</div>