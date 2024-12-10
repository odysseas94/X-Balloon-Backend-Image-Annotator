<?php

namespace app\models\pure;

use app\models\Model;
use Yii;

/**
 * This is the model class for table "user_type".
 *
 * @property int $id
 * @property string $name
 * @property string $pretty_name
 * @property string $date_created
 * @property string $date_updated
 *
 * @property User[] $users
 */
class UserType extends Model
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'pretty_name'], 'required'],
            [['date_created', 'date_updated'], 'safe'],
            [['name', 'pretty_name'], 'string', 'max' => 128],
            [['name'], 'unique'],
            [['pretty_name'], 'unique'],
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
            'pretty_name' => Yii::t('app', 'Pretty Name'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['user_type_id' => 'id']);
    }


    public static function getAllRestrictedCurrent()
    {
        if (Yii::$app->user->identity->isAdmin) {
            return self::findBySql("select * from user_type where id>1")->all();

        } else {
            return self::findBySql("select * from user_type where id<=2")->all();
        }

    }
}
