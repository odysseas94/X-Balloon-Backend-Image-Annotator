<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "action".
 *
 * @property int $id
 * @property int $machine_id
 * @property int $action_category_id
 * @property int $user_id the one who did start the action
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property Machine $machine
 * @property User $user
 * @property ActionCategory $actionCategory
 * @property ActionLog[] $actionLogs
 * @property Log[] $logs
 */
class Action extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'action';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['machine_id', 'action_category_id', 'user_id'], 'required'],
            [['machine_id', 'action_category_id', 'user_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['machine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machine_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['action_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActionCategory::className(), 'targetAttribute' => ['action_category_id' => 'id']],
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
            'action_category_id' => 'Action Category ID',
            'user_id' => 'User ID',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[ActionCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActionCategory()
    {
        return $this->hasOne(ActionCategory::className(), ['id' => 'action_category_id']);
    }

    /**
     * Gets query for [[ActionLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActionLogs()
    {
        return $this->hasMany(ActionLog::className(), ['action_id' => 'id']);
    }

    /**
     * Gets query for [[Logs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Log::className(), ['id' => 'log_id'])->viaTable('action_log', ['action_id' => 'id']);
    }
}
