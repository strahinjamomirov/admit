<?php
/**
 * @link http://www.writesdown.com/
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel cms\models\search\PostComment */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $postType cms\models\PostType */
/* @var $post cms\models\Post */

$this->title = Yii::t('cms', '{postType} Comments', ['postType' => $postType->singular_name]);
$this->params['breadcrumbs'][] = ['label' => $postType->singular_name, 'url' => ['index', 'posttype' => $postType->id]];

if ($post) {
    $this->params['breadcrumbs'][] = $post->id;
    $this->title = Yii::t('cms', '{postType} {post} Comments', [
        'postType' => $postType->singular_name,
        'post' => $post->id,
    ]);
}

$this->params['breadcrumbs'][] = Yii::t('cms', 'Comments');
?>
<div class="post-comment-index">
    <?= $this->render('_search', ['model' => $searchModel, 'postType' => $postType, 'post' => $post]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'post-comment-grid-view',
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            'author:ntext',
            'email:email',
            [
                'attribute' => 'content',
                'format' => 'html',
                'value' => function ( $model) {
                    return substr(strip_tags($model->content), 0, 150) . '...';
                },
            ],
            'date',
            [
                'attribute' => 'status',
                'filter' => $searchModel->getStatuses(),
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Yii::$app->user->can('editor') ? '{view} {update} {delete} {reply}' : '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            $model->commentPost->url . '#comment-' . $model->id, [
                                'title' => Yii::t('yii', 'View'),
                                'data-pjax' => '0',
                            ]);
                    },
                    'reply' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-share-alt"></span>', [
                            'reply',
                            'id' => $model->id,
                        ], [
                            'title' => Yii::t('cms', 'Reply'),
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>

    <?php Pjax::end() ?>

</div>
<?php $this->registerJs('jQuery(".bulk-button").click(function(e){
    e.preventDefault();
    if(confirm("' . Yii::t("app", "Are you sure?") . '")){
        var ids     = $("#post-comment-grid-view").yiiGridView("getSelectedRows");
        var action  = $(this).parents(".form-group").find(".bulk-action").val();
        $.ajax({
            url: "' . Url::to(["bulk-action"]) . '",
            data: { ids: ids, action: action, _csrf: yii.getCsrfToken() },
            type:"POST",
            success: function(data){
                $.pjax.reload({container:"#post-comment-grid-view"});
            }
        });
    }
});') ?>
