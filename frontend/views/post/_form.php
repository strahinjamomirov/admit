<?php
/**
 * Created by PhpStorm.
 * User: strahinja
 * Date: 5/24/18
 * Time: 10:26 PM
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="container">
    <div class="login-container">
        <div class="form-box">
        <?php $form = ActiveForm::begin([]) ?>
        <div class="row">
            <div class="form-group" style="margin-top:20px">
                <div class="col-sm-12">
                    <?= $form->field($model, 'content')->textarea(['rows' => '12', 'class' => 'form-control',
                                                                               'placeholder' => 'Enter your confession!(Up to 2000 characters)' ])->label('Enter Your Confession') ?>
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
</div>

<style>
    body{background: #eee url(http://subtlepatterns.com/patterns/sativa.png);}
    html,body{
        position: relative;
        height: 100%;
    }

    .login-container{
        position: relative;
        width: 300px;
        margin: 80px auto;
        padding: 20px 40px 40px;
        text-align: center;
        background: #fff;
        border: 1px solid #ccc;
    }

    .login-container::before,.login-container::after{
        content: "";
        position: absolute;
        width: 100%;height: 100%;
        top: 3.5px;left: 0;
        background: #fff;
        z-index: -1;
        -webkit-transform: rotateZ(4deg);
        -moz-transform: rotateZ(4deg);
        -ms-transform: rotateZ(4deg);
        border: 1px solid #ccc;

    }

    .login-container::after{
        top: 5px;
        z-index: -2;
        -webkit-transform: rotateZ(-2deg);
        -moz-transform: rotateZ(-2deg);
        -ms-transform: rotateZ(-2deg);

    }
</style>