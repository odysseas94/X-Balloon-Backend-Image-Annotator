<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pure\WeightFile;

/**
 * WeightFileSearch represents the model behind the search form of `app\models\pure\WeightFile`.
 */
class WeightFileSearch extends WeightFile
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'path', 'date_created', 'date_updated'], 'safe'],
            [['success_ratio', 'error_ratio', 'val_loss', 'val_rpn_class_loss', 'val_rpn_bbox_loss', 'val_mrcnn_class_loss', 'val_mrcnn_bbox_loss', 'val_mrcnn_mask_loss', 'rpn_class_loss', 'rpn_bbox_loss', 'mrcnn_class_loss', 'mrcnn_bbox_loss', 'mrcnn_mask_loss'], 'number'],
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
        $query = WeightFile::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
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
            'success_ratio' => $this->success_ratio,
            'error_ratio' => $this->error_ratio,
            'val_loss' => $this->val_loss,
            'val_rpn_class_loss' => $this->val_rpn_class_loss,
            'val_rpn_bbox_loss' => $this->val_rpn_bbox_loss,
            'val_mrcnn_class_loss' => $this->val_mrcnn_class_loss,
            'val_mrcnn_bbox_loss' => $this->val_mrcnn_bbox_loss,
            'val_mrcnn_mask_loss' => $this->val_mrcnn_mask_loss,
            'rpn_class_loss' => $this->rpn_class_loss,
            'rpn_bbox_loss' => $this->rpn_bbox_loss,
            'mrcnn_class_loss' => $this->mrcnn_class_loss,
            'mrcnn_bbox_loss' => $this->mrcnn_bbox_loss,
            'mrcnn_mask_loss' => $this->mrcnn_mask_loss,

        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'date_created', $this->date_created])
        ->andFilterWhere(['like', 'date_updated', $this->date_updated]);

        return $dataProvider;
    }
}
