<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "testing_configuration".
 *
 * @property int $testing_id
 * @property int $configuration_id
 * @property string $value
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property Hyperconfiguration $configuration
 * @property Testing $testing
 */
class TestingConfiguration extends \app\models\Model
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'testing_configuration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['testing_id', 'configuration_id', 'value'], 'required'],
            [['testing_id', 'configuration_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['value'], 'string', 'max' => 512],
            [['testing_id', 'configuration_id'], 'unique', 'targetAttribute' => ['testing_id', 'configuration_id']],
            [['configuration_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hyperconfiguration::className(), 'targetAttribute' => ['configuration_id' => 'id']],
            [['testing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testing::className(), 'targetAttribute' => ['testing_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'testing_id' => Yii::t('app', 'Testing ID'),
            'configuration_id' => Yii::t('app', 'Configuration ID'),
            'value' => Yii::t('app', 'Value'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
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

    /**
     * Gets query for [[Testing]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTesting()
    {
        return $this->hasOne(Testing::className(), ['id' => 'testing_id']);
    }
}
