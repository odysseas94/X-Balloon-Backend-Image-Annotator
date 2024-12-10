<?php

namespace app\models\search;

use app\models\pure\DatasetConfiguration;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pure\Hyperconfiguration;

/**
 * HyperconfigurationSearch represents the model behind the search form of `app\models\pure\Hyperconfiguration`.
 */
class DatasetConfigurationSearch extends DatasetConfiguration
{
    /**
     * {@inheritdoc}
     */


    public $id, $default_value, $name,$description;

    public function rules()
    {
        return [
            [['id', 'dataset_id', 'configuration_id'], 'integer'],
            [['name', 'default_value', 'description', 'date_created', 'date_updated', 'value'], 'safe'],
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
        $query = self::find()->select([
            "hyperconfiguration.id as id",
            "hyperconfiguration.name as name",
            "hyperconfiguration.description as description",
            "hyperconfiguration.default_value as default_value",
            "dataset_configuration.*"


        ]);

        $query->rightJoin("hyperconfiguration", "hyperconfiguration.id=dataset_configuration.configuration_id and dataset_id=$this->dataset_id");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);
        $dataProvider->sort->attributes["id"] = [
            'asc' => ['hyperconfiguration.id' => SORT_ASC],
            'desc' => ['hyperconfiguration.id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes["default_value"] = [
            'asc' => ['hyperconfiguration.default_value' => SORT_ASC],
            'desc' => ['hyperconfiguration.default_value' => SORT_DESC],
        ];
        $dataProvider->sort->attributes["name"] = [
            'asc' => ['hyperconfiguration.name' => SORT_ASC],
            'desc' => ['hyperconfiguration.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'dataset_configuration.date_created' => $this->date_created,
            'dataset_configuration.date_updated' => $this->date_updated,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'default_value', $this->default_value])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
