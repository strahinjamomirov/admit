<?php

namespace common\models\search;

use common\models\UserIp;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserIpSearch represents the model behind the search form of `common\models\UserIp`.
 */
class UserIpSearch extends UserIp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_banned'], 'integer'],
            [['ip', 'country'], 'safe'],
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
        $query = UserIp::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'        => $this->id,
            'is_banned' => $this->is_banned
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip]);
        $query->andFilterWhere(['like', 'country', $this->country]);

        return $dataProvider;
    }
}
