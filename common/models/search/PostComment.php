<?php
/**
 * @link http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

namespace common\models\search;

use common\models\PostComment as PostCommentModel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PostComment represents the model behind the search form about `cms\models\PostComment`.
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.1.0
 */
class PostComment extends PostCommentModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'post_id', 'parent', 'likes', 'dislikes', 'is_enabled'], 'integer'],
            [['author', 'ip', 'date', 'content'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array    $params
     *
     * @param int|null $post        Post ID
     *
     * @return ActiveDataProvider
     */
    public function search($params, $post = null)
    {
        $query = PostCommentModel::find();

        $query->innerJoinWith([
            'commentPost' => function ($query) {
                /* @var $query \yii\db\ActiveQuery */
                return $query->from(['post' => Post::tableName()]);
            },
        ])->from(['postComment' => PostComment::tableName()]);

        if ($post) {
            $query->andWhere(['post.id' => $post]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'postComment.id' => $this->id,
            'post_id' => $this->post_id,
            'parent' => $this->parent,
            'likes' => $this->likes,
            'dislikes' => $this->dislikes,
            'is_enabled' => $this->is_enabled
        ]);

        $query->andFilterWhere(['like', 'postComment.author', $this->author])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'postComment.content', $this->content])
            ->andFilterWhere(['like', 'postComment.date', $this->date]);

        return $dataProvider;
    }
}
