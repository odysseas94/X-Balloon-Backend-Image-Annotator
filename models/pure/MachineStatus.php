<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "machine_status".
 *
 * @property int $id
 * @property string $name
 * @property string $pretty_name
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property Machine[] $machines
 */
class MachineStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'machine_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'pretty_name'], 'required'],
            [['date_created', 'date_updated'], 'safe'],
            [['name', 'pretty_name'], 'string', 'max' => 127],
            [['name'], 'unique'],
        ];
    }

    public function getLabelByName(){
        if($this->name==="online"){
            return "kt-portlet--solid-success";
        }
        else if($this->name==="offline"){
            return "kt-portlet--solid-danger";
        }
        else{
            return "kt-portlet--solid-warning";
        }
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'pretty_name' => Yii::t('app', 'Pretty Name'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[Machines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMachines()
    {
        return $this->hasMany(Machine::className(), ['machine_status_id' => 'id']);
    }
}
