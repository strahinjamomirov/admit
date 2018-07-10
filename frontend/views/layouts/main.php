<?php
/**
 * @link      http://www.beamusup.com/
 * @author    Zivorad Antonijevic <zivorad.antonijevic@gmail.com>
 * @copyright Copyright (c) 2018 BeamUsUp
 * @license   http://www.beamusup.com/license/
 */


use dominus77\sweetalert2\Alert;

/* @var $this yii\web\View */
/* @var $content string */
?>
<?php $this->beginContent('@app/views/layouts/blank.php') ?>
<div class="wrap">
    <?= $this->render('main-header') ?>
    <div class="container">
        <?= Alert::widget([
            'useSessionFlash' => true,
            'options'         => [
                'allowOutsideClick' => true,
                'timer'             => 1000
            ]
        ]) ?>
        <?= $content ?>
    </div>
    <?= $this->render('main-footer') ?>
</div>
<?php $this->endContent() ?>
