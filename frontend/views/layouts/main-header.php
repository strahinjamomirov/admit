<?php
/**
 * @link      http://www.beamusup.com/
 * @author    Zivorad Antonijevic <zivorad.antonijevic@gmail.com>
 * @copyright Copyright (c) 2018 BeamUsUp
 * @license   http://www.beamusup.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
?>
<header id="top-header">
    <div id="nav-wrap">
        <h1>
            <a id="main-logo" href="<?= Url::to(['post/index']) ?>"><?= Html::img('/images/logo.png',
                    ['class' => 'img img-responsive', 'style' => ['width' => '290px', 'height' => '50px']]) ?></a>
        </h1>

        <div id="nav-items">
            <div class="nav-item last">
                <a id="confess" href="<?= Url::to(['post/create']) ?>"><?= Yii::t('app', 'Confess')?></a>
            </div>
        </div>
    </div>
    <div id="section-nav">
        <div id="sticky-nav" class="absolute" style="z-index:0">
            <div id="width-limit">
                <div class="options">
                    <ul>
                        <li>
                            <a href="<?= Url::to(['post/new']) ?>">
                                <?= Yii::t('app', 'New') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['post/featured']) ?>">
                                <?= Yii::t('app', 'Best') ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>


