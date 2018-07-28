<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 app
 * @license   http://www.app.com/license/
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $post common\models\Post */
/* @var $model common\models\PostComment */
?>

<div id="respond" class="post-comment-form">
    <h3 class="reply-title"><?= Yii::t('app', 'Leave a Reply') ?></h3>


    <p>
        <?= Html::a('<strong>' . Yii::t('app', 'Cancel Reply') . '</strong>', '#', [
            'id'    => 'cancel-reply',
            'class' => 'cancel-reply',
            'style' => 'display:none;',
        ]) ?>

    </p>

    <?php $form = ActiveForm::begin() ?>

    <?= Html::activeHiddenInput($model, 'parent', ['value' => 0, 'class' => 'comment-parent-field']) ?>

    <?= Html::activeHiddenInput($model, 'post_id', ['value' => $post->id]) ?>

    <?= $form->field($model, 'author')->textInput() ?>


    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>

    </div>
    <?php ActiveForm::end() ?>

</div>
<style>
    .control-label, .reply-title {
        color:white;
    }

    #postcomment-content, #postcomment-author{
        background: rgba(50, 50, 50, 0.8);
    }
</style>

