<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pure\Training;

/**
 * TrainingSearch represents the model behind the search form of `app\models\pure\Training`.
 */
class TrainingSearch extends Training
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_id'], 'integer'],
            [['name', 'logs', "classification_ids",
                'date_created', 'date_updated'], 'safe'],
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
        $query = Training::find()->select([
            "training.*",
            "group_concat(classification.pretty_name,' ') as classification_ids"
        ]);
        $query->leftJoin("training_classification", "training_classification.training_id=training.id");
        $query->innerJoin("classification", "classification.id=classification_id");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes["classification_ids"] = [
            'asc' => ['classification.pretty_name' => SORT_ASC],
            'desc' => ['classification.pretty_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'training.id' => $this->id,
            'training.status_id' => $this->status_id,

        ]);

        $query->andFilterWhere(['like', 'training.name', $this->name])
            ->andFilterWhere(['like', 'classification.pretty_name', $this->classification_ids])
            ->andFilterWhere(['like', 'training.logs', $this->logs])
            ->andFilterWhere(['like', 'training.date_created', $this->date_created])
            ->andFilterWhere(['like', 'training.date_updated', $this->date_updated]);
        $query->groupBy("training.id");

        return $dataProvider;
    }
}
