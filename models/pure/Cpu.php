<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "cpu".
 *
 * @property int $id
 * @property string $name
 * @property int $cores
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property MachineCpu[] $machineCpus
 * @property Machine[] $machines
 */
class Cpu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cpu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'cores'], 'required'],
            [['cores'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['name'], 'string', 'max' => 127],
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
            'cores' => Yii::t('app', 'Cores'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[MachineCpus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMachineCpus()
    {
        return $this->hasMany(MachineCpu::className(), ['cpu_id' => 'id']);
    }

    /**
     * Gets query for [[Machines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMachines()
    {
        return $this->hasMany(Machine::className(), ['id' => 'machine_id'])->viaTable('machine_cpu', ['cpu_id' => 'id']);
    }
}
