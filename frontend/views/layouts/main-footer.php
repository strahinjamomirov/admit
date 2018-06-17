<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

?>
<footer style="position:relative">
    <div id="footer-wrap">
        <div class="foot-sub-div">

        </div>
        <div class="foot-sub-div">
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
                <li>
                    <a class="soc-foot-link" href="#" id="soc-foot-link-fb"></a>
                    <a class="soc-foot-link" href="#" id="soc-foot-link-tw"></a>
                    <a class="soc-foot-link" href="#"
                       id="soc-foot-link-gp"></a>
                    <a class="soc-foot-link" href="#" id="soc-foot-link-in"></a>
                </li>
            </ul>
        </div>
        <div class="foot-sub-div-logo">
            <ul id="foot-logo">
                <li>
                    <div id="foot-img"></div>
                </li>
                <li id="caption"><?= Yii::t('app', 'Confessr.com') ?><br><?= Yii::t('app',
                        'Anonymous personal confessions') ?></li>
            </ul>
        </div>

    </div>
    <div id="foot-bottom-div">
        <div id="copyright">
            <strong>Copyright &copy; <?= date('Y') . ' ' . Yii::$app->name ?>.</strong> All rights reserved.
            <a href="<?= Url::to(['site/terms-of-use']) ?>">
                <?= Yii::t('app', 'Terms of use') ?>
            </a>
            &nbsp; · &nbsp;
            <a href="<?= Url::to(['site/faq'])?>"><?= Yii::t('app', 'FAQ') ?></a>
            &nbsp; · &nbsp;
            <a href="<?= Url::to(['site/contact'])?>"><?= Yii::t('app', 'Contact') ?></a>
            &nbsp; · &nbsp;
            <a href="<?= Url::to(['site/about-us'])?>"><?= Yii::t('app', 'About us') ?></a>
            &nbsp; · &nbsp;
            <a href="<?= Url::to(['site/marketing'])?>"><?= Yii::t('app', 'Marketing') ?></a>
        </div>
    </div>
</footer>
<style rel="inline-ready">
    a {
        text-decoration: none;
        color:inherit;
    }
    dl, menu, ol, ul {
        margin: 0;
        list-style-type: none;
    }
    footer {
        width: 100%;
        bottom: 0;
        height: 250px;
        position: relative;
        background: rgb(20, 20, 20);
    }
    #footer-wrap {
        width: 940px;
        margin: 0 auto;
        height: 200px;
        color: #fefec7;
        font-size: 14px;
        padding-top: 20px;
    }
    .foot-sub-div {
        width: 300px;
        float: right;
    }
    .foot-sub-div-logo {
        width: 285px;
        float: left;
        height: 85%;
        border-right: 1px solid rgba(100,100,100,0.2);
    }
    footer li {
        padding: 10px;
        cursor: pointer;
        color: #bbb;
    }
    #foot-img {
        float: left;
        width: 180px;
        height: 75px;
        background: url(../../images/foot_img.png) no-repeat;
    }
    #caption {
        margin-left: -75px;
        color: #fff;
        text-align: center;
        opacity: 0.7;
    }

    #foot-bottom-div {
        height: 40px;
        width: 100%;
        background: rgb(15,15,15);
    }
    #copyright {
        padding-top: 12px;
        color: #888;
        font-size: 12px;
        width: 940px;
        margin: 0px auto;
    }
</style>