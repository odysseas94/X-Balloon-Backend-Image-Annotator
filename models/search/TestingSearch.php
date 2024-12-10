<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pure\Testing;

/**
 * TestingSearch represents the model behind the search form of `app\models\pure\Testing`.
 */
class TestingSearch extends Testing
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dataset_id', 'status_id'], 'integer'],
            [['name', 'active', 'description', 'date_created', 'date_updated'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Testing::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'dataset_id' => $this->dataset_id,
            'status_id' => $this->status_id,

        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'active', $this->active])
            ->andFilterWhere(['like', 'date_created', $this->date_created])
            ->andFilterWhere(['like', 'date_updated', $this->date_updated])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
