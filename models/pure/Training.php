<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "training".
 *
 * @property int $id
 * @property string $name
 * @property string $logs
 * @property int $status_id
 * @property string $date_created
 * @property string $date_updated
 *
 * @property Dataset[] $datasets
 * @property AIStatus $status
 * @property string $prettyName
 * @property TrainingWeights $trainingWeights
 */
class Training extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $classification_ids;
    public static function tableName()
    {
        return 'training';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'logs', 'status_id'], 'required'],
            [['logs'], 'string'],
            [['status_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['name'], 'string', 'max' => 512],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => AIStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }


    public function getPrettyName()
    {
        return $this->name . " [" . Yii::t("app",$this->status->prettyName) . "] ";
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'classification_ids' => Yii::t('app', 'Classifications'),
            'logs' => Yii::t('app', 'Comments'),
            'status_id' => Yii::t('app', 'Status'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }


    public function getClassifications()
    {
        return $this->hasMany(Classification::className(), ['id' => 'classification_id'])->viaTable('training_classification', ['training_id' => 'id']);
    }

    public function getTrainingClassifications()
    {
        return $this->hasMany(TrainingClassification::className(), ['training_id' => 'id']);
    }


    /**
     * Gets query for [[Datasets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDatasets()
    {
        return $this->hasMany(Dataset::className(), ['training_id' => 'id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(AIStatus::className(), ['id' => 'status_id']);
    }

    /**
     * Gets query for [[TrainingWeights]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingWeights()
    {
        return $this->hasOne(TrainingWeights::className(), ['training_id' => 'id']);
    }
}
