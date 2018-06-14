<?php
/**
 * Created by PhpStorm.
 * User: strahinja
 * Date: 5/24/18
 * Time: 9:57 PM
 */

namespace frontend\controllers;


use common\models\Post;
use common\models\PostComment as Comment;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Action for creating new post.
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $render = 'index';

        $query = Post::find()->andWhere(['status' => 'publish'])
            ->andWhere(['<=', 'date', date('Y-m-d H:i:s')])
            ->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize'   => Yii::$app->params['postPerPage'],
        ]);

        $query->offset($pages->offset)->limit($pages->limit);

        $posts = $query->all();

        return $this->render($render, [
            'posts' => $posts,
            'pages' => $pages,
        ]);
    }

    /**
     * Displays a single Post model.
     *
     * @param null    $slug Post slug
     * @param integer $id   Post ID
     *
     * @throws \yii\web\NotFoundHttpException
     * @return mixed
     */
    public function actionView($id = null, $slug = null, $category = null)
    {
        $render = 'view';
        $comment = new Comment();

        if ($id) {
            $model = $this->findModel($id);
        } else {
            throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
        }

        if ($comment->load(Yii::$app->request->post()) && $comment->save()) {
            if (!$comment->parent) {
                $model->comment_count++;
            }
            if ($model->save()) {
                $this->refresh();
            }
        }

        return $this->render($render, [
            'post'    => $model,
            'comment' => $comment,
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
    protected function findModel($id)
    {
        /** @var Post $model */
        $model = Post::find()
            ->andWhere(['id' => $id, 'status' => 'publish'])
            ->andWhere(['<=', 'date', date('Y-m-d H:i:s')])
            ->one();

        if ($model) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('cms', 'The requested page does not exist.'));
    }

}