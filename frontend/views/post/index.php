<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

use cms\models\Option;
use cms\models\Taxonomy;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $posts common\models\Post[] */
/* @var $pages yii\data\Pagination */

$this->title = Html::encode(Yii::$app->params['siteTitle']);
Yii::$app->controller->layout = 'post';

?>
<div class="post-index">
    <?php if ($posts): ?>
        <?php foreach ($posts as $post):
            $date = date('H', strtotime($post->date));
            ?>
            <div class="confession">
                <div class="confession-top-content">
                    <a class="confession-id" href="<?= Url::to(['post/view', 'id' => $post->id]) ?>" target="_blank">#<?=$post->id?></a>
                    <div class="confession-timestamp"><?= $date ?></div>
                </div>
                <div class="confession-text">
                    <?= $post->content ?>
                </div>
                <div class="confession-data">
                    <div class="confession-values">
                        <div class="confession-value" id="praise-count-<?= $post->id ?>" data-id="<?= $post->id ?>"><?= $post->likes ?></div>
                        <div class="confession-value" id="condemn-count-<?= $post->id ?>" data-id="<?= $post->id ?>"><?= $post->dislikes ?></div>
                        <a class="confession-value" href="<?= Url::to(['post/view', 'id' => $post->id]) ?>"><?= $post->comment_count ?></a>
                        <div class="confession-value">share</div>
                    </div>
                    <div class="confession-actions">
                        <div class="confession-action border-right praise" data-id="<?= $post->id ?>"><div class="slider"></div>Praise</div>
                        <div class="action-separator"></div>
                        <div class="confession-action border-right condemn" data-id="<?= $post->id ?>"><div class="slider"></div>Condemn</div>
                        <div class="action-separator"></div>
                        <a href="<?= Url::to(['post/view', 'id' => $post->id]) ?>" target="_blank" class="confession-action border-right comments-icon"></a>
                        <div class="action-separator"></div>

                        <div class="confession-action share-icon">
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach ?>
        <div class="pagerArea text-center">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'activePageCssClass' => 'active',
                'disabledPageCssClass' => 'disabled',
                'options' => [
                    'class' => 'pager',
                ],
            ]) ?>

        </div>
    <?php endif ?>
</div>

<style>
    .post-index {
        width: 600px;
        padding-top: 3px;
        opacity: 1;
        display: inline-block;
        background-color: rgba(50, 50, 50, .3);
        margin-bottom: 20px;
        box-shadow: 0 0 8px rgba(0, 0, 0, .7);
        -moz-box-shadow: 0 0 8px rgba(0, 0, 0, .7);
        -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .7);
        float: left;
    }
    .confession-actions {
        border-top: 1px solid rgba(200, 200, 200, .1);
        height: 40px;
        line-height: 32px;
        box-sizing: border-box;
        position: relative;
    }
    .confession-id, .confession-timestamp {
        color: #FEFEFE;
        opacity: .5;
        font-size: 12px;
        transition: opacity .2s linear;
        text-decoration: none;
    }
    .confession {
        background-color: rgba(50, 50, 50, .2);
        letter-spacing: 1px;
        box-shadow: 0 0 3px rgba(0, 0, 0, .3);
        -moz-box-shadow: 0 0 3px rgba(0, 0, 0, .3);
        -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, .3);
        cursor: pointer;
        margin: 10px;
    }
    .confession-id {
        float: left;
    }
    .confession-timestamp {
        float: right;
    }
    .confession-top-content {
        top: 0;
        padding: 8px;
        height: 15px;
    }
    .confession-data {
        width: 100%;
    }
    .confession-text {
        color: #fefec7;
        padding: 10px 10px 20px;
    }
    .confession-values {
        height: 28px;
    }
    .confession-value {
        width: 25%;
        text-align: center;
        color: #FEFEFE;
        opacity: .65;
        font-size: 10px;
        float: left;
        margin-top: 10px;
    }
    .action-separator {
        width: 0px;
        height: 26px;
        margin-top: 7px;
        float: left;
        border-right: 1px solid rgba(200, 200, 200, .1);
    }
    .confession-action {
        color: #DEDEDE;
        float: left;
        font-size: 12px;
        width: 144px;
        text-align: center;
        box-sizing: border-box;
        height: 40px;
    }
    .praise .slider {
        background-color: #3eabff;
    }
    .condemn .slider {
        background-color: #bf2c0f;
    }
    .comments-icon {
        background-size: 23px;
        background: url(/images/comment_empty.png) no-repeat 63px 10px;
        opacity: 0.8;
    }
    a {
        text-decoration: none;
        color: inherit;
    }
</style>