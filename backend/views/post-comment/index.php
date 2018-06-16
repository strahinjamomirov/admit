<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

use common\components\Box;
use common\models\PostComment;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PostComment */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $post common\models\Post */

$this->title = Yii::t('app', 'Confession Comments');
?>
<div class="post-comment-index">
    <?php Box::begin([
        'box'   => Box::BOX_PRIMARY,
        'solid' => false,
        'label' => $this->title,
    ]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'id'           => 'post-comment-grid-view',
        'columns'      => [
            'post_id',
            'author:ntext',
            'ip',
            [
                'attribute' => 'content',
                'format'    => 'html',
                'value'     => function ($model) {
                    return substr(strip_tags($model->content), 0, 150) . '...';
                },
            ],
            [
                'attribute'           => 'date',
                'format'              => 'raw',
                'value'               => function ($model) {
                    /** @var PostComment $model */
                    return Yii::$app->formatter->asDate($model->date, 'php:d.m.Y');
                },
                'filterType'          => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'type'          => \kartik\date\DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'allowClear'     => true,
                        'format'         => 'dd.mm.yyyy',
                        'todayHighlight' => true
                    ],
                ],
            ],
            'parent',
            'likes',
            'dislikes',
            [
                'attribute'  => 'is_enabled',
                'trueLabel'  => 'Yes',
                'falseLabel' => 'No',
                'class'      => 'common\components\ToggleColumn',
                'action'     => 'toggle-comment-enabled'
            ],
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons'  => [
                    'delete' => function ($url, $model) {
                        /* @var $model \common\models\search\PostComment */
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
    ]) ?>

    <?php Box::end() ?>

</div>
