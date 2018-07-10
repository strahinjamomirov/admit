<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;

?>
<div class="confess-container">
    <div class="form-box">
        <?php $form = ActiveForm::begin([]) ?>
        <div class="row">
            <div class="form-group" style="margin-top:20px">
                <div class="col-sm-12">
                    <?= $form->field($model, 'content')->textarea([
                        'rows'        => '12',
                        'class'       => 'form-control',
                        'placeholder' => 'Enter your confession!(Up to 2000 characters)'
                    ])->label('Enter Your Confession') ?>
                </div>
                <div class="col-sm-12">
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::class) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group" style="margin-top:20px">
                <div class="col-sm-12">
                    <?= Html::submitButton('Confess', ['class' => 'btn btn-block btn-success']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
