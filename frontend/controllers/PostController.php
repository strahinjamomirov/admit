<?php

namespace frontend\controllers;


use common\components\IpHelper;
use common\models\Post;
use common\models\PostComment as Comment;
use dominus77\sweetalert2\Alert;
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

        if ($model->load(Yii::$app->request->post())) {
            $ipAddress = Yii::$app->request->userIP;
            $checkBlacklist = IpHelper::checkBlacklist($ipAddress);
            $checkNumber = IpHelper::checkConfessesForDay($ipAddress);
            if ($checkBlacklist) {
                Yii::$app->session->setFlash(Alert::TYPE_ERROR, Yii::t('app', 'Your ip is blacklisted.'));
                return $this->redirect(['create']);
            }
            if ($checkNumber) {
                Yii::$app->session->setFlash(Alert::TYPE_WARNING,
                    Yii::t('app', 'You have already posted three confessions for today'));
                return $this->redirect(['create']);
            }
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $render = 'index';

        $query = Post::find()
            ->andWhere(['<=', 'date', date('Y-m-d')])
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
     * @param integer $id Post ID
     *
     * @throws \yii\web\NotFoundHttpException
     * @return mixed
     */
    public function actionView($id = null)
    {
        $render = 'view';
        $comment = new Comment();

        if ($id) {
            $model = $this->findModel($id);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
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
            ->where(['id' => $id])
            ->one();

        if ($model) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}