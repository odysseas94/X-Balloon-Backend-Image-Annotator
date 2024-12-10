<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "training_classification".
 *
 * @property int $training_id
 * @property int $classification_id
 * @property string $date_created
 * @property string $date_updated
 *
 * @property Training $training
 * @property Classification $classification
 */
class TrainingClassification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'training_classification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_id', 'classification_id'], 'required'],
            [['training_id', 'classification_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['training_id', 'classification_id'], 'unique', 'targetAttribute' => ['training_id', 'classification_id']],
            [['training_id'], 'exist', 'skipOnError' => true, 'targetClass' => Training::className(), 'targetAttribute' => ['training_id' => 'id']],
            [['classification_id'], 'exist', 'skipOnError' => true, 'targetClass' => Classification::className(), 'targetAttribute' => ['classification_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'training_id' => Yii::t('app', 'Training'),
            'classification_id' => Yii::t('app', 'Classification'),
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

    /**
     * Gets query for [[Classification]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClassification()
    {
        return $this->hasOne(Classification::className(), ['id' => 'classification_id']);
    }
}
