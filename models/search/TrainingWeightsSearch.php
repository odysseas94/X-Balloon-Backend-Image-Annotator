<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pure\TrainingWeights;

/**
 * TrainingWeightsSearch represents the model behind the search form of `app\models\pure\TrainingWeights`.
 */
class TrainingWeightsSearch extends TrainingWeights
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_id', 'weight_child_id', 'weight_parent_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
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
        $query = TrainingWeights::find();

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
            'training_id' => $this->training_id,
            'weight_child_id' => $this->weight_child_id,
            'weight_parent_id' => $this->weight_parent_id,

        ]);
        $query->andFilterWhere(["like","date_created",$this->date_created])
            ->andFilterWhere(["like","date_updated",$this->date_updated]);

        return $dataProvider;
    }
}
