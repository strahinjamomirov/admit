<?php
/**
 * @link      http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

namespace backend\controllers;

use common\components\ToggleAction;
use common\models\Post;
use common\models\PostComment;
use common\models\search\PostComment as PostCommentSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PostCommentController, controlling the actions for PostComment model.
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since  0.1.0
 */
class PostCommentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'delete', 'toggle-comment-enabled', 'like-comment', 'dislike-comment'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete'                 => ['post'],
                    'toggle-comment-enabled' => ['post']
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'toggle-comment-enabled' => [
                'class'      => ToggleAction::class,
                'modelClass' => PostComment::class,
                'attribute'  => 'is_enabled'
            ],
        ];
    }


    /**
     * Lists all PostComment models on specific post type.
     * If there is post_id the action will generate list of all PostComment models based on post_id.
     *
     * @param null|integer $post Post ID
     *
     * @throws \yii\web\NotFoundHttpException
     * @return string
     */
    public function actionIndex($post = null)
    {
        $postId = null;

        if ($post) {
            $post = $this->findPost($post);
            $postId = $post->id;
        }

        $searchModel = new PostCommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $postId);

        return $this->render('index', [
            'post'         => $post,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPost($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Deletes an existing PostComment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $post = $model->commentPost;

        if ($model->delete()) {
            if (!$model->parent) {
                $post->updateAttributes(['comment_count', --$post->comment_count]);
            }
            PostComment::deleteAll(['parent' => $model->id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the PostComment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return PostComment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PostComment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Function that increases number of likes
     *
     */
    public function actionLikeComment()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            /** @var PostComment $postComment */
            $postComment = PostComment::find()->where(['id' => $data['id']])->one();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (!$postComment) {
                return [
                    'notExisting' => true
                ];
            }

            $postComment->likes = $postComment->likes + 1;
            //$postComment->scenario = 'default';
            $postComment->save();

            $numberOfLikes = $postComment->likes - $postComment->dislikes;
            return [
                'id'            => $postComment->id,
                'numberOfLikes' => $numberOfLikes,
                'notExisting'   => false
            ];
        }
    }

    /**
     * Function that increases number of dislikes
     *
     */
    public function actionDislikeComment()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            /** @var PostComment $postComment */
            $postComment = PostComment::find()->where(['id' => $data['id']])->one();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (!$postComment) {
                return [
                    'notExisting' => true
                ];
            }

            $postComment->dislikes = $postComment->dislikes + 1;
            //$post->scenario = 'default';
            $postComment->save();
            $numberOfLikes = $postComment->likes - $postComment->dislikes;
            return [
                'id'            => $postComment->id,
                'numberOfLikes' => $numberOfLikes,
                'notExisting'   => false
            ];
        }
    }
}
