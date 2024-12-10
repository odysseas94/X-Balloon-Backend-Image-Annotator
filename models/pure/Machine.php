<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "machine".
 *
 * @property int $id
 * @property string $name
 * @property string $os
 * @property string $mac
 * @property int $ram
 * @property int $machine_status_id
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property MachineStatus $machineStatus
 * @property MachineCpu[] $machineCpus
 * @property Cpu[] $cpus
 * @property Cpu $cpu
 * @property MachineGpu[] $machineGpus
 * @property Gpu[] $gpus
 * @property MachineIpAddress[] $machineIpAddresses
 * @property UserMachine[] $userMachines
 * @property User[] $users
 */
class Machine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'machine';
    }

    public function getFullDetails()
    {
        $result = [];
        $result["ram"] = $this->ram / pow(1024, 3);
        $cpu = $this->cpu;
        $result["cpu"] = [
            "name" => $cpu->name,
            'cores' => $cpu->cores
        ];
        $result["gpus"] = [];
        foreach ($this->gpus as $gpu) {
            $result["gpus"][] = [
                "name" => $gpu->name,
                "vram" => $gpu->vram/pow(1024, 3)
            ];
        }
        return $result;
    }


    public function getFullDetailsLabeled()
    {

        $detail = $this->getFullDetails();
        $result = [];
        $result["ram"] = Yii::t("app", "RAM") . " : " . round($detail["ram"],1) . " GB";

        $result["cpu"] = [
            "name" =>  Yii::t("app", "CPU") . " : " . $detail["cpu"]["name"],
            'cores' => Yii::t("app", "CPU : {cpu} Cores", ["cpu" => $detail["cpu"]["cores"]])
        ];
        $result["gpus"] = [];
        foreach ($detail["gpus"] as $gpu) {
            $result["gpus"][] = [
                "name" => Yii::t("app", "GPU") . " : " . $gpu["name"],
                "vram" =>Yii::t("app", "VRAM") . " : " . $gpu["vram"]." GB",
            ];
        }
        return $result;

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'mac', 'ram', 'os','machine_status_id'], 'required'],
            [['ram', 'machine_status_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['name','os'], 'string', 'max' => 127],
            [['mac'], 'string', 'max' => 17],
            [['mac'], 'unique'],
            [['machine_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => MachineStatus::className(), 'targetAttribute' => ['machine_status_id' => 'id']],
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
            'os' => Yii::t('app', 'Operating System'),
            'mac' => Yii::t('app', 'MAC'),
            'ram' => Yii::t('app', 'RAM'),
            'machine_status_id' => Yii::t('app', 'Machine Status'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[MachineStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMachineStatus()
    {
        return $this->hasOne(MachineStatus::className(), ['id' => 'machine_status_id']);
    }

    /**
     * Gets query for [[MachineCpus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMachineCpus()
    {
        return $this->hasMany(MachineCpu::className(), ['machine_id' => 'id']);
    }

    /**
     * Gets query for [[Cpus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCpus()
    {
        return $this->hasMany(Cpu::className(), ['id' => 'cpu_id'])->viaTable('machine_cpu', ['machine_id' => 'id']);
    }

    public function getCpu()
    {
        return $this->hasOne(Cpu::className(), ['id' => 'cpu_id'])->viaTable('machine_cpu', ['machine_id' => 'id']);
    }

    /**
     * Gets query for [[MachineGpus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMachineGpus()
    {
        return $this->hasMany(MachineGpu::className(), ['machine_id' => 'id']);
    }

    /**
     * Gets query for [[Gpus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGpus()
    {
        return $this->hasMany(Gpu::className(), ['id' => 'gpu_id'])->viaTable('machine_gpu', ['machine_id' => 'id']);
    }

    /**
     * Gets query for [[MachineIpAddresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMachineIpAddresses()
    {
        return $this->hasMany(MachineIpAddress::className(), ['machine_id' => 'id']);
    }

    /**
     * Gets query for [[UserMachines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserMachines()
    {
        return $this->hasMany(UserMachine::className(), ['machine_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_machine', ['machine_id' => 'id']);
    }
}
