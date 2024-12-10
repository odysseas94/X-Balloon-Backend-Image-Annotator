<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "hyperconfiguration".
 *
 * @property int $id
 * @property string $name
 * @property string $default_value
 * @property string|null $description
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property DatasetConfiguration[] $datasetConfigurations
 * @property Dataset[] $datasets
 */
class Hyperconfiguration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hyperconfiguration';
    }
   public $override_value;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'default_value'], 'required'],
            [['description'], 'string'],
            [['date_created', 'date_updated'], 'safe'],
            [['name'], 'string', 'max' => 127],
            [['default_value'], 'string', 'max' => 512],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'default_value' => Yii::t('app', 'Default Value'),
            'description' => Yii::t('app', 'Description'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[DatasetConfigurations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDatasetConfigurations()
    {
        return $this->hasMany(DatasetConfiguration::className(), ['configuration_id' => 'id']);
    }

    /**
     * Gets query for [[Datasets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDatasets()
    {
        return $this->hasMany(Dataset::className(), ['id' => 'dataset_id'])->viaTable('dataset_configuration', ['configuration_id' => 'id']);
    }
}
