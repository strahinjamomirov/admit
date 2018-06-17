<?php
/**
 * @link      http://www.beamusup.com/
 * @author    Zivorad Antonijevic <zivorad.antonijevic@gmail.com>
 * @copyright Copyright (c) 2018 BeamUsUp
 * @license   http://www.beamusup.com/license/
 */


use codezeen\yii2\adminlte\widgets\Alert;

/* @var $this yii\web\View */
/* @var $content string */
?>
<?php $this->beginContent('@app/views/layouts/blank.php') ?>
<div class="wrap">
        <?= $this->render('main-header') ?>
        <div class="content-wrapper">
            <section class="content clearfix">
                <?= Alert::widget() ?>
                <?= $content ?>
            </section>
        </div>
        <?= $this->render('main-footer') ?>
</div>
<?php $this->endContent() ?>
