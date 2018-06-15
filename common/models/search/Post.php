<?php
/**
 * @link      http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

namespace cms\models\search;

use common\models\Post as PostModel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\QueryBuilder;
use yii\helpers\ArrayHelper;

/**
 * Post represents the model behind the search form about `cms\models\Post`.
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since  0.1.0
 */
class Post extends PostModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'comment_count', 'views_count', 'likes', 'dislikes', 'featured'], 'integer'],
            [
                [
                    'content',
                    'author_ip',
                    'date',
                    'modified',
                    'status',
                    'comment_status',
                ],
                'safe',
            ],
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
     * @param array        $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PostModel::find();

        $query->prepare(new QueryBuilder(Yii::$app->db));

        $query->groupBy('post.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $originalSort = $dataProvider->sort->attributes;
        unset($originalSort['id']);
        $dataProvider->setSort([
            'attributes'   => ArrayHelper::merge($originalSort, [
                'username'   => [
                    'asc'   => ['username' => SORT_ASC],
                    'desc'  => ['username' => SORT_DESC],
                    'label' => 'Author',
                    'value' => 'username',
                ],
                'id'         => [
                    'asc'  => ['post.id' => SORT_ASC],
                    'desc' => ['post.id' => SORT_DESC],

                ],
                'categories' => [
                    'asc'  => ['categories' => SORT_ASC],
                    'desc' => ['categories' => SORT_DESC],

                ]
            ]),
            'defaultOrder' => ['id' => SORT_DESC],
        ]);

        $this->load($params);

        if ( ! $this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'post.id'       => $this->id,
            'author_id'     => $this->author_id,
            'post.type_id'  => $this->type_id,
            'is_featured'   => $this->is_featured,
            'comment_count' => $this->comment_count,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
              ->andFilterWhere(['like', 'excerpt', $this->excerpt])
              ->andFilterWhere(['like', 'content', $this->content])
              ->andFilterWhere(['like', 'post.status', $this->status])
              ->andFilterWhere(['like', 'password', $this->password])
              ->andFilterWhere(['like', 'slug', $this->slug])
              ->andFilterWhere(['like', 'comments_enabled', $this->comments_enabled])
              ->andFilterWhere(['like', 'username', $this->username]);


        return $dataProvider;
    }
}
