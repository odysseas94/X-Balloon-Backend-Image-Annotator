<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "user_machine".
 *
 * @property int $user_id
 * @property int $machine_id
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property User $user
 * @property Machine $machine
 */
class UserMachine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_machine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'machine_id'], 'required'],
            [['user_id', 'machine_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['user_id', 'machine_id'], 'unique', 'targetAttribute' => ['user_id', 'machine_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['machine_id'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machine_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'machine_id' => 'Machine ID',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        ];
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
     * Gets query for [[Machine]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMachine()
    {
        return $this->hasOne(Machine::className(), ['id' => 'machine_id']);
    }
}
