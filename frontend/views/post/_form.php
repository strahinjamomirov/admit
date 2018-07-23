<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;

?>
    <?php $form = ActiveForm::begin([]) ?>
    <div class="row">
        <div class="col-md-offset-3 col-md-6 post-wrap">
            <div class="row">
                <div class="form-group" style="margin-top:20px">
                    <div class="col-sm-12">
                        <?= $form->field($model, 'content')->textarea([
                            'rows'        => '12',
                            'class'       => 'form-control',
                            'placeholder' => 'Enter your confession!(Up to 1000 characters)'
                        ])->label('Enter Your Confession') ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group" style="margin-top:20px">
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
        </div>
    </div>

    <?php ActiveForm::end(); ?>
<style>
    .post-wrap {
        padding: 20px;
        /*margin: 20px;*/
        background: rgba(50, 50, 50, 0.8);
    }
    .control-label {
        color:white;
    }

    #post-content{
        background: rgba(50, 50, 50, 0.8);
    }

    #post-verifycode-image{
        background: rgba(50, 50, 50, 0.8);
    }

    #post-verifycode{
        background: rgba(50, 50, 50, 0.8);
    }
</style>