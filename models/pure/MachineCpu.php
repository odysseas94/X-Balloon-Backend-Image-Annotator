<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "machine_cpu".
 *
 * @property int $machine_id
 * @property int $cpu_id
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property Machine $machine
 * @property Cpu $cpu
 */
class MachineCpu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'machine_cpu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['machine_id', 'cpu_id'], 'required'],
            [['machine_id', 'cpu_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['machine_id', 'cpu_id'], 'unique', 'targetAttribute' => ['machine_id', 'cpu_id']],
            [['machine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machine_id' => 'id']],
            [['cpu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cpu::className(), 'targetAttribute' => ['cpu_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'machine_id' => Yii::t('app', 'Machine ID'),
            'cpu_id' => Yii::t('app', 'Cpu ID'),
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

    /**
     * Gets query for [[Cpu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCpu()
    {
        return $this->hasOne(Cpu::className(), ['id' => 'cpu_id']);
    }
}
