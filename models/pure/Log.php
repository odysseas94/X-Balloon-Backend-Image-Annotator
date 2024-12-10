<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property int $machine_id
 * @property int $log_category_id
 * @property string $content
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property ActionLog[] $actionLogs
 * @property Action[] $actions
 * @property LogCategory $logCategory
 * @property Machine $machine
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['machine_id', 'log_category_id', 'content'], 'required'],
            [['machine_id', 'log_category_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['content'], 'string', 'max' => 512],
            [['log_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => LogCategory::className(), 'targetAttribute' => ['log_category_id' => 'id']],
            [['machine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machine_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'machine_id' => 'Machine ID',
            'log_category_id' => 'Log Category ID',
            'content' => 'Content',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        ];
    }

    /**
     * Gets query for [[ActionLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActionLogs()
    {
        return $this->hasMany(ActionLog::className(), ['log_id' => 'id']);
    }

    /**
     * Gets query for [[Actions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActions()
    {
        return $this->hasMany(Action::className(), ['id' => 'action_id'])->viaTable('action_log', ['log_id' => 'id']);
    }

    /**
     * Gets query for [[LogCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLogCategory()
    {
        return $this->hasOne(LogCategory::className(), ['id' => 'log_category_id']);
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
