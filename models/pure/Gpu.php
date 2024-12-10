<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "gpu".
 *
 * @property int $id
 * @property string $name
 * @property string $uuid
 * @property int $vram
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property MachineGpu[] $machineGpus
 * @property Machine[] $machines
 */
class Gpu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gpu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'uuid', 'vram'], 'required'],
            [['vram'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['name'], 'string', 'max' => 127],
            [['uuid'], 'string', 'max' => 63],
            [['uuid'], 'unique'],
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
            'uuid' => Yii::t('app', 'Uuid'),
            'vram' => Yii::t('app', 'Vram'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[MachineGpus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMachineGpus()
    {
        return $this->hasMany(MachineGpu::className(), ['gpu_id' => 'id']);
    }

    /**
     * Gets query for [[Machines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMachines()
    {
        return $this->hasMany(Machine::className(), ['id' => 'machine_id'])->viaTable('machine_gpu', ['gpu_id' => 'id']);
    }
}
