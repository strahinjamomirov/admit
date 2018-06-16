<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

use common\components\Box;
use common\models\Post;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \common\models\search\Post */

$this->title = Yii::t('app', 'Confessions');
?>
<div class="post-index">
    <?php Box::begin([
        'box'   => Box::BOX_PRIMARY,
        'solid' => false,
        'label' => $this->title,
    ]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'id'           => 'post-grid-view',
        'columns'      => [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            [
                'attribute'  => 'featured',
                'trueLabel'  => 'Yes',
                'falseLabel' => 'No',
                'class'      => 'common\components\ToggleColumn',
                'action'     => 'toggle-featured'
            ],
            [
                'attribute'           => 'date',
                'format'              => 'raw',
                'value'               => function ($model) {
                    /** @var Post $model */
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
            [
                'label'     => 'Content',
                'attribute' => 'content'
            ],
            [
                'label'     => 'Author IP address',
                'attribute' => 'author_ip'
            ],
            [
                'label'     => 'Views Count',
                'attribute' => 'views_count',
            ],

            [
                'label'     => 'Likes',
                'attribute' => 'likes',
            ],
            [
                'label'     => 'Dislikes',
                'attribute' => 'dislikes',
            ],
            [
                'label'     => 'Comment Count',
                'attribute' => 'comment_count',
            ],
            [
                'attribute'  => 'comment_enabled',
                'trueLabel'  => 'Yes',
                'falseLabel' => 'No',
                'class'      => 'common\components\ToggleColumn',
                'action'     => 'toggle-comments'
            ],
            [
                'attribute'  => 'is_enabled',
                'trueLabel'  => 'Yes',
                'falseLabel' => 'No',
                'class'      => 'common\components\ToggleColumn',
                'action'     => 'toggle-enabled'
            ],
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons'  => [
                    'delete' => function ($url, $model) {
                        /* @var $model \common\models\search\Post */
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
