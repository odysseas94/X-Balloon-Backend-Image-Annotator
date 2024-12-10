<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "{{%image_creator}}".
 *
 * @property int $image_id
 * @property int $user_id
 *
 * @property Image $image
 * @property User $user
 */
class ImageCreator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%image_creator}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_id', 'user_id'], 'required'],
            [['image_id', 'user_id'], 'integer'],
            [['image_id', 'user_id'], 'unique', 'targetAttribute' => ['image_id', 'user_id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'image_id' => Yii::t('app', 'Image'),
            'user_id' => Yii::t('app', 'User'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
