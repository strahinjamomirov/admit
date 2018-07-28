<?php

namespace frontend\controllers;


use common\components\IpHelper;
use common\models\Post;
use common\models\PostComment as Comment;
use common\models\PostComment;
use common\models\UserIp;
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post())) {
            $ipAddress = Yii::$app->request->userIP;

            $checkBlacklistMessage = $this->checkBlacklisted($ipAddress);
            if ($checkBlacklistMessage) {
                return $checkBlacklistMessage;
            }
            $checkNumberMessage = $this->checkNumber($ipAddress);
            if ($checkNumberMessage) {
                return $checkNumberMessage;
            }
            $this->checkExistingIp($ipAddress);
            $model->author_ip = $ipAddress;
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Redirecting for banned ip.
     *
     * @param $ipAddress
     *
     * @return \yii\web\Response
     */
    private function checkBlacklisted($ipAddress)
    {
        $checkBlacklist = IpHelper::checkBlacklist($ipAddress);
        if ($checkBlacklist) {
            Yii::$app->session->setFlash(Alert::TYPE_ERROR, Yii::t('app', 'Your ip is blacklisted.'));
            return $this->redirect(['create']);
        }
        return null;
    }

    /**
     *
     * Redirecting for more than three confesses.
     *
     * @param $ipAddress
     *
     * @return \yii\web\Response
     */
    private function checkNumber($ipAddress)
    {
        $checkNumber = IpHelper::checkConfessesForDay($ipAddress);
        if ($checkNumber) {
            Yii::$app->session->setFlash(Alert::TYPE_WARNING,
                Yii::t('app', 'You have already posted three confessions for today'));
            return $this->redirect(['create']);
        }
        return null;
    }

    /**
     * Saving country for new user ip.
     *
     * @param $ipAddress
     */
    private function checkExistingIp($ipAddress)
    {
        $checkExistingIpAddress = UserIp::find()->where(['ip' => $ipAddress])->one();
        if (!$checkExistingIpAddress) {
            $res = file_get_contents('https://www.iplocate.io/api/lookup/87.116.177.20');
            $res = json_decode($res);
            if ($res) {
                $newUserIp = new UserIp();
                $newUserIp->ip = $ipAddress;
                $newUserIp->country = $res->country;
                $newUserIp->save();
            }
        }
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $render = 'index';

        $query = Post::find()
            ->andWhere(['<=', 'date', date('Y-m-d')])
            ->andWhere(['is_enabled' => 1])
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
     * Rendering new confessions.
     *
     * @return string
     */
    public function actionNew()
    {
        $render = 'index';

        $query = Post::find()
            ->andWhere(['<=', 'date', date('Y-m-d')])
            ->andWhere(['is_enabled' => 1])
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
     * Rendering featured confessions.
     *
     * @return string
     */
    public function actionFeatured()
    {
        $render = 'index';

        $query = Post::find()
            ->andWhere(['<=', 'date', date('Y-m-d')])
            ->andWhere(['is_enabled' => 1])
            ->orderBy(['is_enabled' => SORT_DESC, 'likes' => SORT_DESC]);

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

        if ($comment->load(Yii::$app->request->post())) {
            $ipAddress = Yii::$app->request->userIP;
            $checkBlacklist = $this->checkBlacklisted($ipAddress);
            if ($checkBlacklist) {
                return $checkBlacklist;
            }
            if (!$comment->save()) {
                Yii::$app->session->setFlash(Alert::TYPE_ERROR, Yii::t('app', 'There was an error while commenting.'));
                return $this->redirect(['index']);
            }

            if (!$comment->parent || $comment->parent == '0') {
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

    /**
     * Function that increases number of likes
     *
     */
    public function actionLikePost()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            /** @var Post $post */
            $post = Post::find()->where(['id' => $data['id']])->one();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (!$post) {
                return [
                    'notExisting' => true
                ];
            }

            $post->likes = $post->likes + 1;
            $post->scenario = 'default';
            $post->save();
            return [
                'id'             => $post->id,
                'increasedLikes' => $post->likes,
                'notExisting'    => false
            ];
        }
    }

    /**
     * Function that increases number of dislikes
     *
     */
    public function actionDislikePost()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            /** @var Post $post */
            $post = Post::find()->where(['id' => $data['id']])->one();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (!$post) {
                return [
                    'notExisting' => true
                ];
            }

            $post->dislikes = $post->dislikes + 1;
            $post->scenario = 'default';
            $post->save();
            return [
                'id'                => $post->id,
                'increasedDislikes' => $post->dislikes,
                'notExisting'       => false
            ];
        }
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
            $postComment->scenario = 'default';
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
            $postComment->scenario = 'default';
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