<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */


/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = Yii::t('app','Add New Confession');
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
