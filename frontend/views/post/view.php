<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

use cms\models\Option;
use cms\models\Taxonomy;
use frontend\assets\CommentAsset;
use frontend\components\FrontendHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $post cms\models\Post */

$this->title = Html::encode($post->title . ' - ' . Option::get('sitetitle'));
$date = date('d-M', strtotime($post->date));
$date = explode('-', $date);
Yii::$app->controller->layout = 'post';
$frontendHelper = new FrontendHelper();

if ($seo = $post->getMeta('seo')) {
	if ($metaDescription = ArrayHelper::getValue($seo, 'description')) {
		$this->registerMetaTag([
			'name' => 'description',
			'content' => $metaDescription,
		]);
		$this->params['pageSubTitle'] = $metaDescription;
		\Yii::$app->view->registerMetaTag([
			'property' => 'og:description',
			'content' => $metaDescription
		]);
	} else {
		$this->registerMetaTag([
			'name' => 'description',
			'content' => substr($post->excerpt, 0, 350),
		]);
	}
	if ($metaKeywords = ArrayHelper::getValue($seo, 'keywords')) {
		$this->registerMetaTag([
			'name' => 'keywords',
			'content' => $metaKeywords,
		]);
	}
}

\Yii::$app->view->registerMetaTag([
	'property' => 'og:image',
	'content' => 'http://www.kockakockica.com/uploads/' . $post->thumbnail
]);
\Yii::$app->view->registerMetaTag([
	'property' => 'og:title',
	'content' => $post->title
]);

\Yii::$app->view->registerMetaTag([
	'property' => 'og:type',
	'content' => 'article'
]);

\Yii::$app->view->registerMetaTag([
	'property' => 'og:site_name',
	'content' => 'www.kockakockica.com'
]);


?>
<div class="single post-view">
    <div class="thumbnail thumbnailContent">
        <img src="<?= 'uploads/' . $post->thumbnail ?>" alt="image"
             class="img-responsive">
        <div class="sticker-round bg-color-1"><?= $date[0] ?><br><?= $date[1] ?></div>
        <div class="caption border-color-1 singleBlog">
            <h3 class="color-1"><?= $post->title ?></h3>
            <?= $frontendHelper->handleContentTags($post->content) ?>
            <br>
            <div class="addthis_inline_share_toolbox"></div>
        </div>
    </div>
</div>
