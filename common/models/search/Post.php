<?php
/**
 * @link      http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

namespace common\models\search;

use common\models\Post as PostModel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\QueryBuilder;

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
            [['id', 'comment_count', 'views_count', 'likes', 'dislikes', 'featured', 'comment_enabled'], 'integer'],
            [
                [
                    'content',
                    'author_ip',
                    'date',
                    'modified',
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
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PostModel::find();

        $query->prepare(new QueryBuilder(Yii::$app->db));

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $originalSort = $dataProvider->sort->attributes;
        $dataProvider->setSort([
            'attributes'   => $originalSort,
            'defaultOrder' => ['id' => SORT_DESC],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->date) {
            $query->andFilterWhere(['date' => Yii::$app->formatter->asDate($this->date, 'php:Y-m-d')]);
        }

        $query->andFilterWhere([
            'id'              => $this->id,
            'featured'        => $this->featured,
            'comment_count'   => $this->comment_count,
            'comment_enabled' => $this->comment_enabled,
            'views_count'     => $this->views_count,
            'likes'           => $this->likes,
            'dislikes'        => $this->dislikes
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);
        $query->andFilterWhere(['like', 'author_ip', $this->author_ip]);

        return $dataProvider;
    }
}
