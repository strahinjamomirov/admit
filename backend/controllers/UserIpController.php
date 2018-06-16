<?php

namespace backend\controllers;

use common\components\ToggleAction;
use common\models\Post;
use common\models\search\UserIpSearch;
use common\models\UserIp;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserIpController implements the CRUD actions for UserIp model.
 */
class UserIpController extends Controller
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
                        'actions' => [
                            'index',
                            'delete',
                            'toggle-banned'
                        ],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete'        => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'toggle-banned' => [
                'class'      => ToggleAction::class,
                'modelClass' => UserIp::class,
                'attribute'  => 'is_banned',
                'afterSave' => function ($model, $attribute) {
                    return $this->changePost($model, $attribute);
                },
            ],
        ];
    }

    /**
     * Lists all UserIp models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserIpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing UserIp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserIp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return UserIp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserIp::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param UserIp $model
     * @param $attribute
     */
    private function changePost($model, $attribute)
    {
        /** @var Post[] $posts */
        $posts = Post::find()->where(['author_ip' => $model->ip])->all();
        foreach ($posts as $post) {
            $postComments = $post->postComments;
            foreach ($postComments as $postComment) {
                $postComment->is_enabled = 0;
                $postComment->save();
            }
            $post->is_enabled = 0;
            $post->save();
        }
    }
}
