<?php
/**
 * @author  Agiel K. Saputra <13nightevil@gmail.com>
 */

/* @var $this \yii\web\View */
/* @var $content string */

?>
<?php $this->beginContent('@app/views/layouts/blank.php') ?>
<div class="wrapper">
    <?= $this->render('main-header'); ?>
    <?= $this->render('main-sidebar'); ?>
    <div class="content-wrapper">
        <section class="content clearfix">
            <?= $this->render('//layouts/alerts'); ?>

            <?= $content; ?>

        </section>
    </div>
    <?= $this->render('main-footer'); ?>
</div>
<?php $this->endContent() ?>
