<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "machine_ip_address".
 *
 * @property int $machine_id
 * @property int $ip_address
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property Machine $machine
 */
class MachineIpAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'machine_ip_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['machine_id', 'ip_address', 'date_created'], 'required'],
            [['machine_id', 'ip_address'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['machine_id', 'ip_address', 'date_created'], 'unique', 'targetAttribute' => ['machine_id', 'ip_address', 'date_created']],
            [['machine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machine_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'machine_id' => Yii::t('app', 'Machine ID'),
            'ip_address' => Yii::t('app', 'Ip Address'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[Machine]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMachine()
    {
        return $this->hasOne(Machine::className(), ['id' => 'machine_id']);
    }
}
