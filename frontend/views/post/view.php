<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */


use common\components\View;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $pages yii\data\Pagination */
/* @var $post common\models\Post */
/* @var $comment common\models\PostComment */

$this->title = Html::encode(Yii::$app->params['siteTitle']);
Yii::$app->controller->layout = 'post';
Yii::$app->params['bodyClass'] = 'confess-page';

$this->registerJs("

$('body').on('click', '.praise', function () {
        likeFunction($(this).data('id'));
    });
    $('body').on('click', '.condemn', function () {
        dislikeFunction($(this).data('id'));
    });
       $('body').on('click', '.report-post', function () {
        reportPost($(this).data('id'));
    });

");

$this->registerJs("var urlLike = '" . Yii::$app->request->baseUrl . Url::to(['post/like-post']) . "';",
    View::POS_BEGIN);

$this->registerJs("var urlDislike = '" . Yii::$app->request->baseUrl . Url::to(['post/dislike-post']) . "';",
    View::POS_BEGIN);

$this->registerJs("var urlReportPost = '" . Yii::$app->request->baseUrl . Url::to(['post/report-post']) . "';",
    View::POS_BEGIN);

$this->registerJs("var _csrf = '" . Yii::$app->request->getCsrfToken() . "';", View::POS_BEGIN);

?>
<div class="post-index">
    <?php
    $date = date('m/d/Y', strtotime($post->date));
    ?>
    <div class="confession">
        <div class="confession-top-content">
            <a class="confession-id link-color" href="<?= Url::to(['post/view', 'id' => $post->id]) ?>"
               target="_blank">#<?= $post->id ?></a>
            <div class="report-post link-color"
                 data-id="<?= $post->id ?>">
                 Report
            </div>
            <div class="confession-timestamp"> <?= $date ?></div>

        </div>
        <div class="confession-text">
            <?= $post->content ?>
        </div>
        <div class="confession-data">
            <div class="confession-values">
                <div class="confession-value" id="praise-count-<?= $post->id ?>"
                     data-id="<?= $post->id ?>"><?= $post->likes ?></div>
                <div class="confession-value" id="condemn-count-<?= $post->id ?>"
                     data-id="<?= $post->id ?>"><?= $post->dislikes ?></div>
                <a class="confession-value link-color"
                   href="<?= Url::to(['post/view', 'id' => $post->id]) ?>"><?= $post->comment_count ?></a>
                <div class="confession-value">share</div>
            </div>
            <div class="confession-actions">
                <div class="confession-action border-right praise" data-id="<?= $post->id ?>">
                    <div class="slider"></div>
                    Praise
                </div>
                <div class="action-separator"></div>
                <div class="confession-action border-right condemn" data-id="<?= $post->id ?>">
                    <div class="slider"></div>
                    Condemn
                </div>
                <div class="action-separator"></div>
                <a href="<?= Url::to(['post/view', 'id' => $post->id]) ?>" target="_blank"
                   class="confession-action border-right comments-icon"></a>
                <div class="action-separator"></div>

                <div class="confession-action share-icon">
                </div>

            </div>
        </div>
    </div>

    <?= $this->render('/post-comment/comments', ['post' => $post, 'comment' => $comment]) ?>
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
                    var praiseCount = $('#praise-count-' + data.id);
                    praiseCount.text(data.increasedLikes);
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
                    var condemnCount = $('#condemn-count-' + data.id);
                    condemnCount.text(data.increasedDislikes);
                }
            }
        });
    }

    function reportPost(id) {
        $.ajax({
            url: urlReportPost,
            type: 'post',
            data: {
                id: id,
                _csrf: _csrf
            },
            success: function (data) {
            }
        });
    }

</script>