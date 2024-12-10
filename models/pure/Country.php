<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property string $iso
 * @property string $name
 * @property string $nicename
 * @property string $iso3
 * @property int $numcode
 * @property int $phonecode
 * @property int $active
 * @property string $translation
 *
 * @property User[] $users
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iso', 'name', 'nicename', 'phonecode'], 'required'],
            [['numcode', 'phonecode', 'active'], 'integer'],
            [['iso'], 'string', 'max' => 2],
            [['name', 'nicename'], 'string', 'max' => 80],
            [['iso3'], 'string', 'max' => 3],
            [['translation'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'iso' => Yii::t('app', 'Iso'),
            'name' => Yii::t('app', 'Name'),
            'nicename' => Yii::t('app', 'Nicename'),
            'iso3' => Yii::t('app', 'Iso3'),
            'numcode' => Yii::t('app', 'Numcode'),
            'phonecode' => Yii::t('app', 'Phonecode'),
            'active' => Yii::t('app', 'Active'),
            'translation' => Yii::t('app', 'Translation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['country_id' => 'id']);
    }
}
