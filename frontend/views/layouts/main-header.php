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
<header id="pageTop" class="header-wrapper">
    <nav id="menuBar" class="navbar lightHeader" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>"><?= Html::img('/images/logo.png',
                    ['alt' => 'Confessr', 'class' => 'img img-responsive', 'style' => ['width' => '320px', 'height' => '50px']]) ?>
                </a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">

                    <li class="active dropdown">
                        <a id="confess" class="dropdown-toggle"
                        aria-haspopup="true" aria-expanded="false" href="<?= Url::to(['post/create']) ?>"><?= Yii::t('app', 'Confess')?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="top-info-bar bg-color-7 hidden-xs">
        <div class="container">
            <div class="row" id="second-navbar">
                <div class="col-sm-7">
                    <ul class="list-inline topList">
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


