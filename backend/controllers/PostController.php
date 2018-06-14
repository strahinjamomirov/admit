<?php
/**
 * @link      http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

namespace backend\controllers;

use common\components\ToggleAction;
use common\models\Post;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * PostController implements the CRUD actions for Post model.
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since  0.1.0
 */
class PostController extends Controller
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
                        'actions' => ['index', 'create', 'update', 'delete', 'ajax-search', 'toggle-comments','toggle-enabled'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete'      => ['post'],
                    'bulk-action' => ['post'],
                    'ajax-search' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'toggle-featured' => [
                'class'      => ToggleAction::class,
                'modelClass' => Post::class,
                'attribute'  => 'is_featured'
            ],
            'toggle-comments' => [
                'class'      => ToggleAction::class,
                'modelClass' => Post::class,
                'attribute'  => 'comments_enabled'
            ],
        ];
    }

    /**
     * Lists all Post models on specific post type.
     * If there is user, the action will generate list of all Post models based on user.
     *
     * @param null|integer $user_id
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($user_id = null)
    {
        $searchModel          = new PostSearch();
        $searchModel->is_post = 1;
        $postType             = $this->findPostType(PostSearch::POST_TYPE_ID);
        $dataProvider         = $searchModel->search(Yii::$app->request->queryParams, $user_id);


        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'postType'     => $postType,
            'user_id'      => $user_id
        ]);
    }

    /**
     * Finds the PostType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return PostType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPostType($id)
    {
        if (($model = PostType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'update' page.
     *
     *
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     * @return mixed
     */
    public function actionCreate()
    {
        $type_id                 = PostSearch::POST_TYPE_ID;
        $model                   = new Post();
        $postType                = $this->findPostType($type_id);
        $model->comments_enabled = Option::get('default_comment_status') == 'open' ? 1 : 0;

        if ( ! Yii::$app->user->can($postType->permission)) {
            throw new ForbiddenHttpException(Yii::t('cms', 'You are not allowed to perform this action.'));
        }
        if( Yii::$app->request->isAjax) {
            return $this->ajaxValidate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->type_id      = $postType->id;
            $model->publish_time = date('Y-m-d H:i:s', strtotime($model->publish_time));
            if ($model->save()) {
                if ($termIds = Yii::$app->request->post('termIds')) {
                    foreach ($termIds as $termId) {
                        $termRelationship = new TermRelationship();
                        $termRelationship->setAttributes([
                            'term_id' => $termId,
                            'post_id' => $model->id,
                        ]);
                        if ($termRelationship->save() && $term = $this->findTerm($termId)) {
                            $term->updateAttributes(['count' => ++$term->count]);
                        }
                    }
                }
                if ($meta = Yii::$app->request->post('meta')) {
                    foreach ($meta as $name => $value) {
                        $model->setMeta($name, $value);
                    }
                }
                Yii::$app->getSession()->setFlash('success',
                    Yii::t('cms', '{type} successfully saved.', ['type' => $postType->singular_name]));

                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model'    => $model,
            'postType' => $postType,
        ]);
    }

    /**
     * Finds the Term model based on its primary key value.
     * If the model is not found, it return false.
     *
     * @param integer $id
     *
     * @return Term|bool|null
     */
    protected function findTerm($id)
    {
        if (($model = Term::findOne($id)) !== null) {
            return $model;
        }

        return false;
    }

    /**
     * @param Post $model
     *
     * @return mixed
     */
    protected function ajaxValidate($model)
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->getPermission($model);
        $postType = $model->postType;

        if( Yii::$app->request->isAjax) {
            return $this->ajaxValidate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->publish_time = date('Y-m-d H:i:s', strtotime($model->publish_time));
            if ($model->save()) {
                if ($meta = Yii::$app->request->post('meta')) {
                    foreach ($meta as $name => $value) {
                        $model->setMeta($name, $value);
                    }
                }
                Yii::$app->getSession()->setFlash('success',
                    Yii::t('cms', '{type} successfully saved.', ['type' => $postType->singular_name,]));

                return $this->redirect(['post/update', 'id' => $id]);
            }
        }

        return $this->render('update', [
            'model'    => $model,
            'postType' => $postType,
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
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Get permission to access model by current user.
     * If the user does not obtain the permission, a 403 exception will be thrown.
     *
     * @param $model Post
     *
     * @throws ForbiddenHttpException
     */
    public function getPermission($model)
    {
        if ( ! $model->getPermission()) {
            throw new ForbiddenHttpException(Yii::t('cms', 'You are not allowed to perform this action.'));
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @throws \Exception
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->getPermission($model);

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Search POST model via AJAX with JSON as the response.
     */
    public function actionAjaxSearch()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query                      = Post::find()
                                          ->select(['id', 'title'])
                                          ->andWhere(['like', 'title', Yii::$app->request->post('title')])
                                          ->limit(10);

        if ($postType = Yii::$app->request->post('type_id')) {
            $query->andWhere(['type_id' => $postType]);
        }

        return $query->all();
    }
}
