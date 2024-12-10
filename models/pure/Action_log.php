<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "action_log".
 *
 * @property int $action_id
 * @property int $log_id
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property Action $action
 * @property Log $log
 */
class Action_log extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'action_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['action_id', 'log_id'], 'required'],
            [['action_id', 'log_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['action_id', 'log_id'], 'unique', 'targetAttribute' => ['action_id', 'log_id']],
            [['action_id'], 'exist', 'skipOnError' => true, 'targetClass' => Action::className(), 'targetAttribute' => ['action_id' => 'id']],
            [['log_id'], 'exist', 'skipOnError' => true, 'targetClass' => Log::className(), 'targetAttribute' => ['log_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'action_id' => 'Action ID',
            'log_id' => 'Log ID',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        ];
    }

    /**
     * Gets query for [[Action]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(Action::className(), ['id' => 'action_id']);
    }

    /**
     * Gets query for [[Log]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLog()
    {
        return $this->hasOne(Log::className(), ['id' => 'log_id']);
    }
}
