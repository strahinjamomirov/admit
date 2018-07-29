<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
Yii::$app->controller->layout = 'post';
Yii::$app->params['bodyClass'] = 'confess-page';
?>
<div class="site-contact post-wrap">
    <h1><?= Html::encode($this->title) ?></h1>

    <p class="contact-description">
        If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
    </p>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<style>

    h1, .contact-description {
        color:white;
    }
    .post-wrap {
        padding: 20px;
        /*margin: 20px;*/
        background: rgba(50, 50, 50, 0.8);
    }

    .form-control {
        background: rgba(50, 50, 50, 0.8);
    }
    .control-label {
        color:white;
    }

</style>
