<?php
/**
 * @link      http://www.beamusup.com/
 * @author    Zivorad Antonijevic <zivorad.antonijevic@gmail.com>
 * @copyright Copyright (c) 2018 BeamUsUp
 * @license   http://www.beamusup.com/license/
 */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
?>
<header id="top-header">
    <div id="nav-wrap">
        <h1>
            <a id="main-logo" href="<?= Url::to(['post/index']) ?>">

            </a>
        </h1>

        <div id="nav-items">
            <div class="nav-item last">
                <a id="confess" href="<?= Url::to(['post/create']) ?>"><?= Yii::t('app', 'Confess') ?></a>
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


<style rel="inline-ready">
    #top-header {
        background-color: #333;
        width: 100%;
    }

    #nav-wrap h1 a {
        display: block;
        height: 50px;
        width: 290px;
        background: url(/images/logo.png) no-repeat -25px -242px;
        text-indent: -9999px;
        overflow: hidden;
        text-decoration: none;

    }

    #main-logo {
        float: left;
        margin-left: -25px;
    }

    #nav-wrap {
        width: 940px;
        height: 50px;
        margin: 0 auto;
        position: relative;
    }

    h1 {
        margin: 0;
    }

    #nav-items {
        float: right;
    }

    .nav-item.last {
        border-right: 1px solid #444;
    }

    .nav-item {
        float: right;
        border-left: 1px solid #444;
        border-right: 1px solid #151515;
        height: 50px;
    }

    #confess {
        width: 170px;
        padding-left: 10px;
        display: block;
        font-size: 18px;
        background: url(/images/confess.png) no-repeat 140px 8px;
        color: #cacaca;
        border-right: 1px solid #000;
        line-height: 50px;
        text-decoration: none;
    }

    #sticky-nav {
        position: absolute;
        box-shadow: 0 3px 1px rgba(0, 0, 0, .3);
        background-color: #55f;
        width: 100%;
        z-index: 0;
    }

    #width-limit {
        width: 940px;
        margin: 0 auto;
    }

    .options {
        float: left;
        width: 580px;
    }

    .options ul {
        display: table-row;
    }

    dl, menu, ol, ul {
        margin: 0;
        list-style-type: none;
    }

    .options ul li {
        display: inline-block;
        height: 35px;
        list-style-type: none;
        margin: 0 10px;
        vertical-align: middle;
        line-height: 32px;
    }

    .options ul li a {
        text-decoration: none;
        color: #fff;
        border-bottom: 2px solid transparent;
        display: block;
        border-bottom: 2px solid #fff;
        opacity: 1;
    }
</style>
