<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;

?>
<footer>
    <div class="footerInfoArea full-width clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-4 foot-sub-div-logo">
                    <ul id="foot-logo">
                        <li>
                            <?= Html::img('/images/logo.png', ['class' => 'img img-responsive']) ?>
                        </li>
                        <li id="caption"><?= Yii::t('app', 'Confessr.com') ?><br><?= Yii::t('app',
                                'Anonymous personal confessions') ?></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <a href="#">
                        <?= Html::img('/images/facebook.png',
                            [
                                'class' => 'img img-responsive',
                                'style' => 'margin-left: auto;
    margin-right: auto;
    width: 40%; padding-top: 10px;'
                            ]) ?>
                    </a>

                </div>
                <div class="col-md-4">
                    <a href="#">
                        <?= Html::img('/images/instagram.png',
                            [
                                'class' => 'img img-responsive',
                                'style' => 'margin-left: auto;
    margin-right: auto;
    width: 40%; padding-top: 50px;'
                            ]) ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="copyRight clearfix">
        <div class="container">
            <div class="row">
                <div class="col-sm-7 col-xs-12" id="copyright">
                    <strong>Copyright &copy; <?= date('Y') . ' ' . Yii::$app->name ?>.</strong> All rights reserved.
                    <a href="<?= Url::to(['site/terms-of-use']) ?>">
                        <?= Yii::t('app', 'Terms of use') ?>
                    </a>
                    &nbsp; · &nbsp;
                    <a href="<?= Url::to(['site/faq']) ?>"><?= Yii::t('app', 'FAQ') ?></a>
                    &nbsp; · &nbsp;
                    <a href="<?= Url::to(['site/contact']) ?>"><?= Yii::t('app', 'Contact') ?></a>
                    &nbsp; · &nbsp;
                    <a href="<?= Url::to(['site/about-us']) ?>"><?= Yii::t('app', 'About us') ?></a>
                    &nbsp; · &nbsp;
                    <a href="<?= Url::to(['site/marketing']) ?>"><?= Yii::t('app', 'Marketing') ?></a>
                </div>
            </div>
        </div>
    </div>
</footer>
