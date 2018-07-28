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
        likeFunction($(this).data('id'));
    });
    $('body').on('click', '.condemn-comment', function () {
        dislikeFunction($(this).data('id'));
    });

");
$this->registerJs("var urlLike = '" . Yii::$app->request->baseUrl . Url::to(['post-comment/like-comment']) . "';",
    View::POS_BEGIN);
$this->registerJs("var urlDislike = '" . Yii::$app->request->baseUrl . Url::to(['post-comment/dislike-comment']) . "';",
    View::POS_BEGIN);
$this->registerJs("var _csrf = '" . Yii::$app->request->getCsrfToken() . "';", View::POS_BEGIN);
?>
<div id="comment-view">

    <?php if ($post->comment_count): ?>

        <?= PostComment::widget(['model' => $post, 'id' => 'comments']) ?>

    <?php endif ?>

    <div class="confession">
        <?= $this->render('_form', ['model' => $comment, 'post' => $post]) ?>
    </div>

</div>
<script>
    function likeFunction(id) {
        $.ajax({
            url: urlLike,
            type: 'post',
            data: {
                id: id,
                _csrf: '<?=Yii::$app->request->getCsrfToken()?>'
            },
            success: function (data) {
                var notExisting = data.notExisting;
                if (!notExisting) {
                    var praiseCount = $('#number-of-comments-' + data.id);
                    praiseCount.text(data.newCommentLike);
                }
            }
        });
    }

    function dislikeFunction(id) {
        $.ajax({
            url: urlDislike,
            type: 'post',
            data: {
                id: id,
                _csrf: '<?=Yii::$app->request->getCsrfToken()?>'
            },
            success: function (data) {
                var notExisting = data.notExisting;
                if (!notExisting) {
                    var praiseCount = $('#number-of-comments-' + data.id);
                    praiseCount.text(data.newCommentLike);
                }
            }
        });
    }
</script>