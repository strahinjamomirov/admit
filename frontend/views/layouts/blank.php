<?php
/**
 * @link      http://www.beamusup.com/
 * @author    Zivorad Antonijevic <zivorad.antonijevic@gmail.com>
 * @copyright Copyright (c) 2018 BeamUsUp
 * @license   http://www.beamusup.com/license/
 */


use frontend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $content string */

// Favicon
$this->registerLinkTag(['rel' => 'icon', 'href' => Yii::getAlias('@web/favicon.ico'), 'type' => 'image/x-icon']);

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="<?= isset(Yii::$app->params['bodyClass']) ? Yii::$app->params['bodyClass'] : "skin-purple-light sidebar-mini"; ?>">
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
