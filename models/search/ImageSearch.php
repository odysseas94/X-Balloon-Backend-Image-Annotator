<?php

namespace app\models\search;

use app\models\pure\Image;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ImageSearch represents the model behind the search form of `app\models\pure\Image`.
 */
class ImageSearch extends Image
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'visible', 'shape_available_count', "image_creator", 'shapes_all_count'], 'integer'],
            [['name', 'path', 'thumbnail_path', 'date_created', 'date_updated'], 'safe'],
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

        $query = Image::find()->select([
            "image.*",
            "count(image_shape.shape_id) as shapes_all_count ",
            "image_creator.user_id as image_creator"
        ]);
        $creator_appender="";
        //manager and only creator images
        if(Yii::$app->user->identity->isManager)
            $creator_appender = "and
            (image_creator.user_id=".Yii::$app->user->id." or exists(select user_manager.user_id  from user_manager where image_creator.user_id=user_manager.user_id and user_manager.manager_id=".Yii::$app->user->id."))";

        $query->innerJoin("image_creator", "image_creator.image_id=image.id $creator_appender");
        $query->leftJoin("image_shape", "image.id=image_shape.image_id");

        $query->groupBy("image.id");
        if (!Yii::$app->user->identity->isAdmin) {
            $user_id = Yii::$app->user->id;




        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $dataProvider->sort->attributes["image_creator"] = [
            'asc' => ['image_creator.user_id' => SORT_ASC],
            'desc' => ['image_creator.user_id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes["shapes_all_count"] = [
            'asc' => ['shapes_all_count' => SORT_ASC],
            'desc' => ['shapes_all_count' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'image.id' => $this->id,
            'image.visible' => $this->visible,
            "image_creator.user_id" => $this->image_creator
        ]);

        $query->andFilterWhere(['like', 'image.name', $this->name])
            ->andFilterWhere(['like', 'image.path', $this->path])
            ->andFilterWhere(['like', 'image.date_created', $this->date_created])
            ->andFilterWhere(['like', 'image.thumbnail_path', $this->thumbnail_path]);

        return $dataProvider;
    }
}
