<?php

namespace app\models\search;

use app\helpers\ArrayHelper;
use app\models\pure\DatasetConfiguration;
use app\models\pure\TestingConfiguration;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pure\Hyperconfiguration;

/**
 * HyperconfigurationSearch represents the model behind the search form of `app\models\pure\Hyperconfiguration`.
 */
class TestingConfigurationSearch extends TestingConfiguration
{
    /**
     * {@inheritdoc}
     */


    public $id, $default_value, $name,$description,$dataset_value;
    public $dataset_id;




    public function rules()
    {
        return [
            [['id', 'testing_id', 'configuration_id'], 'integer'],
            [['name', 'default_value', 'description', 'date_created', 'date_updated', 'value','dataset_value'], 'safe'],
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
            "dataset_configuration.value as dataset_value",
            "testing_configuration.*"

        ]);

        $query->innerJoin("testing", "testing.id=testing_configuration.testing_id");
        $query->rightJoin("hyperconfiguration", "hyperconfiguration.id=testing_configuration.configuration_id and testing_id=$this->testing_id");
        $query->leftJoin("dataset_configuration", "dataset_configuration.configuration_id=hyperconfiguration.id and dataset_configuration.dataset_id=$this->dataset_id");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);
        $dataProvider->sort->attributes["id"] = [
            'asc' => ['hyperconfiguration.id' => SORT_ASC],
            'desc' => ['hyperconfiguration.id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes["default_value"] = [
            'asc' => ['dataset_configuration.value' => SORT_ASC],
            'desc' => ['dataset_configuration.value' => SORT_DESC],
        ];

        $dataProvider->sort->attributes["dataset_value"] = [
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
            'hyperconfiguration.id' => $this->id,
            'testing_configuration.date_created' => $this->date_created,
            'testing_configuration.date_updated' => $this->date_updated,
        ]);

        $query->andFilterWhere(['like', 'hyperconfiguration.name', $this->name])
            ->andFilterWhere(['like', 'hyperconfiguration.default_value', $this->default_value])
            ->andFilterWhere(['like', 'dataset_configuration.value', $this->dataset_value])
            ->andFilterWhere(['like', 'hyperconfiguration.description', $this->description]);
        $query->groupBy("hyperconfiguration.id");

        return $dataProvider;
    }



    public function attributeLabels()
    {

        return ArrayHelper::merge(parent::attributeLabels(), [
            'dataset_value' => Yii::t('app', 'Dataset Value'),
        ]);

    }
}
