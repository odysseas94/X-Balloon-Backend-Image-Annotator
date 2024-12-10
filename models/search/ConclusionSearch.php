<?php

namespace app\models\search;

use app\models\pure\Image;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pure\Conclusion;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseArrayHelper;

/**
 * ConclusionSearch represents the model behind the search form of `app\models\pure\Conclusion`.
 */
class ConclusionSearch extends Conclusion
{
    /**
     * {@inheritdoc}
     */


    public function rules()
    {
        return [
            [['id', 'shapes', 'image_id'], 'integer'],
            [['success_json', 'date_created', 'date_updated','average_detection'], 'safe'],
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
        $query = Conclusion::find()->select([
            "conclusion.*",
            "image_id"
        ]);


        $appender = "";
        if (!\Yii::$app->user->identity->isAdmin) {
            $image_ids = \app\helpers\ArrayHelper::keys(Image::getAllRestricted(), "id");
            $appender = " and image_id in (" . implode(",", $image_ids) . ")";
        }


        // add conditions that should always apply here
        $query->innerJoin("testing_images", "testing_images.conclusion_id=conclusion.id $appender");
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $dataProvider->sort->attributes["image_id"] = [
            'asc' => ['testing_images.image_id' => SORT_ASC],
            'desc' => ['testing_images.image_id' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'conclusion.id' => $this->id,
            'image_id' => $this->image_id,
            'conclusion.shapes' => $this->shapes,
        ]);

        $query->andFilterWhere(['like', 'conclusion.success_json', $this->success_json])
            ->andFilterWhere(['like', 'conclusion.date_created', $this->date_created])
            ->andFilterWhere(['like', 'conclusion.average_detection', $this->average_detection])
            ->andFilterWhere(['like', 'conclusion.date_updated', $this->date_updated]);

        return $dataProvider;
    }
}
