<?php

use common\components\Box;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserIpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Ips';
?>
<div class="user-ip-index">
    <?php Box::begin([
        'box'   => Box::BOX_PRIMARY,
        'solid' => false,
        'label' => $this->title,
    ]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'ip',
            'country',
            [
                'attribute'  => 'is_banned',
                'trueLabel'  => 'Yes',
                'falseLabel' => 'No',
                'class'      => 'common\components\ToggleColumn',
                'action'     => 'toggle-banned'
            ],
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons'  => [
                    'delete' => function ($url, $model) {
                        /* @var $model \common\models\UserIp */
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title'        => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method'  => 'post',
                            'data-pjax'    => '0',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Box::end(); ?>
</div>
