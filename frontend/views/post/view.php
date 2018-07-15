<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use frontend\assets\CommentAsset;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $post common\models\Post */
/* @var $comment common\models\PostComment */

$this->title = Html::encode(Yii::$app->params['siteTitle']);

//CommentAsset::register($this);
?>
<div class="single post-view">
    <article class="hentry">

        <?php if (Yii::$app->controller->route !== 'site/index'): ?>
            <header class="entry-header page-header">
                <div class="entry-meta">
                    <span class="comments-link">
                        <span aria-hidden="true" class="glyphicon glyphicon-comment"></span>
                        <a title="<?= Yii::t('app', 'Comment') ?>" href="#respond"><?= Yii::t('app', 'Leave a comment') ?></a>
                    </span>
                </div>
            </header>
        <?php endif ?>
    </article>

    <?= $this->render('/post-comment/comments', ['post' => $post, 'comment' => $comment]) ?>
</div>