<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pure\Shape;

/**
 * ShapeSearch represents the model behind the search form of `app\models\pure\Shape`.
 */
class ShapeSearch extends Shape
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'shape_type_id', 'image_id',"shape_creator" ,'shape_deleted','testing_id', 'class_id'], 'integer'],
            [['points', 'date_created', 'date_updated','area'], 'safe'],
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
        $query = Shape::find()->select([
            "shape.*",
            "image_shape.image_id as image_id",
            "image_shape.deleted as shape_deleted",
            "shape_creator.user_id as shape_creator",
            "image_shape.testing_id as testing_id"
        ]);
        $creator_appender = "";

        if(Yii::$app->user->identity->isManager)
            $creator_appender = "and
            (shape_creator.user_id=".Yii::$app->user->id." or shape_creator.user_id in (select user_manager.user_id  from user_manager where user_manager.manager_id=".Yii::$app->user->id."))";

        $query->innerJoin("image_shape", "image_shape.shape_id=shape.id");
        $query->innerJoin("shape_creator", "shape_creator.shape_id=shape.id $creator_appender");
        $query->cache(100);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $dataProvider->sort->attributes["image_id"] = [
            'asc' => ['image_shape.image_id' => SORT_ASC],
            'desc' => ['image_shape.image_id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes["testing_id"] = [
            'asc' => ['image_shape.testing_id' => SORT_ASC],
            'desc' => ['image_shape.testing_id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes["shape_deleted"] = [
            'asc' => ['image_shape.deleted' => SORT_ASC],
            'desc' => ['image_shape.deleted' => SORT_DESC],
        ];
        $dataProvider->sort->attributes["shape_creator"] = [
            'asc' => ['shape_creator.user_id' => SORT_ASC],
            'desc' => ['shape_creator.user_id' => SORT_DESC],
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
            'shape_type_id' => $this->shape_type_id,
            'testing_id' => $this->testing_id,
            'class_id' => $this->class_id,
            'image_id' => $this->image_id,
            'image_shape.deleted' => $this->shape_deleted,
            'user_id' => $this->shape_creator,

        ]);
        $query->andFilterWhere(['like', 'ara', $this->area]);
        $query->andFilterWhere(['like', 'points', $this->points]);
        $query->andFilterWhere(['like', 'shape.date_created', $this->date_created]);
        $query->andFilterWhere(['like', 'shape.date_updated', $this->date_updated]);
        return $dataProvider;
    }
}
