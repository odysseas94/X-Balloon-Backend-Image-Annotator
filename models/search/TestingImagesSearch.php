<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pure\TestingImages;

/**
 * TestingImagesSearch represents the model behind the search form of `app\models\pure\TestingImages`.
 */
class TestingImagesSearch extends TestingImages
{
    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['testing_id', 'image_id', 'status_id', 'conclusion_id'], 'integer'],
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
        $query = TestingImages::find();

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
            'testing_id' => $this->testing_id,
            'image_id' => $this->image_id,
            'status_id' => $this->status_id,
            'conclusion_id' => $this->conclusion_id,

        ]);
        $query->andFilterWhere(["like","date_created",$this->date_created])
            ->andFilterWhere(["like","date_updated",$this->date_updated]);

        return $dataProvider;
    }
}
