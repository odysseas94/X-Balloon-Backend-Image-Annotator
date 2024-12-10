<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "training_weights".
 *
 * @property int $training_id
 * @property int|null $weight_child_id
 * @property int $weight_parent_id
 * @property string $date_created
 * @property string $date_updated
 *
 * @property Training $training
 * @property WeightFile $weightChild
 * @property WeightFile $weightParent
 */
class TrainingWeights extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'training_weights';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_id', 'weight_parent_id'], 'required'],
            [['training_id', 'weight_child_id', 'weight_parent_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['training_id'], 'unique'],
            [['training_id'], 'exist', 'skipOnError' => true, 'targetClass' => Training::className(), 'targetAttribute' => ['training_id' => 'id']],
            [['weight_child_id'], 'exist', 'skipOnError' => true, 'targetClass' => WeightFile::className(), 'targetAttribute' => ['weight_child_id' => 'id']],
            [['weight_parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => WeightFile::className(), 'targetAttribute' => ['weight_parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'training_id' => Yii::t('app', 'Training'),
            'weight_child_id' => Yii::t('app', 'Weight Child'),
            'weight_parent_id' => Yii::t('app', 'Weight Parent'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[Training]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTraining()
    {
        return $this->hasOne(Training::className(), ['id' => 'training_id']);
    }

    public function getPrettyName(){
        if($this->weight_child_id){
            return "[".$this->weightChild->getPrettyName()."]";

        }
        return "[".$this->weightParent->getPrettyName()."]";
    }


    public function getAttributes($names = null, $except = [])
    {
        $attributes = parent::getAttributes($names, $except); // TODO: Change the autogenerated stub
        if ($this->weight_child_id)
            $attributes["weight_child"] = $this->weightChild->getAttributes();
        if ($this->weight_parent_id)
            $attributes["weight_parent"] = $this->weightParent->getAttributes();

        return $attributes;
    }


    /**
     * Gets query for [[WeightChild]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWeightChild()
    {
        return $this->hasOne(WeightFile::className(), ['id' => 'weight_child_id']);
    }

    /**
     * Gets query for [[WeightParent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWeightParent()
    {
        return $this->hasOne(WeightFile::className(), ['id' => 'weight_parent_id']);
    }
}