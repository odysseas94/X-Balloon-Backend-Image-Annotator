<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pure\TrainingImages;

/**
 * TrainingImagesSearch represents the model behind the search form of `app\models\pure\TrainingImages`.
 */
class TrainingImagesSearch extends TrainingImages
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_id', 'image_id'], 'integer'],
            [['date_created', 'date_updated', 'active'], 'safe'],
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
        $query = TrainingImages::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['date_created' => SORT_DESC]],
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
            'image_id' => $this->image_id,
        ]);

        $query->andFilterWhere(['like', 'active', $this->active])
        ->andFilterWhere(["like",'date_created',$this->date_created])
        ->andFilterWhere(["like","date_updated",$this->date_updated]);

        return $dataProvider;
    }
}
