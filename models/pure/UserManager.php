<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "user_manager".
 *
 * @property int $manager_id
 * @property int $user_id
 * @property string $date_created
 * @property string $date_updated
 *
 * @property User $manager
 * @property User $user
 */
class UserManager extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_manager';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['manager_id', 'user_id'], 'required'],
            [['manager_id', 'user_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['manager_id', 'user_id'], 'unique', 'targetAttribute' => ['manager_id', 'user_id']],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['manager_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'manager_id' => Yii::t('app', 'Manager'),
            'user_id' => Yii::t('app', 'User'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[Manager]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(User::className(), ['id' => 'manager_id']);
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
}
