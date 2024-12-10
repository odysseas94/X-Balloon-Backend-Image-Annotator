<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "machine_gpu".
 *
 * @property int $machine_id
 * @property int $gpu_id
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property Gpu $gpu
 * @property Machine $machine
 */
class MachineGpu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'machine_gpu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['machine_id', 'gpu_id'], 'required'],
            [['machine_id', 'gpu_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['machine_id', 'gpu_id'], 'unique', 'targetAttribute' => ['machine_id', 'gpu_id']],
            [['gpu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gpu::className(), 'targetAttribute' => ['gpu_id' => 'id']],
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
            'gpu_id' => Yii::t('app', 'Gpu ID'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[Gpu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGpu()
    {
        return $this->hasOne(Gpu::className(), ['id' => 'gpu_id']);
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
