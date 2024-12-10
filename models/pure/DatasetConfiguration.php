<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "dataset_configuration".
 *
 * @property int $dataset_id
 * @property int $configuration_id
 * @property string $value
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property Dataset $dataset
 * @property Hyperconfiguration $configuration
 */
class DatasetConfiguration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dataset_configuration';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dataset_id', 'configuration_id', 'value'], 'required'],
            [['dataset_id', 'configuration_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['value'], 'string', 'max' => 512],
            [['dataset_id', 'configuration_id'], 'unique', 'targetAttribute' => ['dataset_id', 'configuration_id']],
            [['dataset_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dataset::className(), 'targetAttribute' => ['dataset_id' => 'id']],
            [['configuration_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hyperconfiguration::className(), 'targetAttribute' => ['configuration_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dataset_id' => Yii::t('app', 'Dataset ID'),
            'configuration_id' => Yii::t('app', 'Configuration ID'),
            'value' => Yii::t('app', 'Value'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[Dataset]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataset()
    {
        return $this->hasOne(Dataset::className(), ['id' => 'dataset_id']);
    }

    /**
     * Gets query for [[Configuration]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConfiguration()
    {
        return $this->hasOne(Hyperconfiguration::className(), ['id' => 'configuration_id']);
    }
}
