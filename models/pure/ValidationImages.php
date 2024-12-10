<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "validation_images".
 *
 * @property int $validation_id
 * @property int $image_id
 * @property string $active
 * @property string $date_created
 * @property string $date_updated
 *
 * @property Image $image
 * @property Validation $validation
 */
class ValidationImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'validation_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['validation_id', 'image_id', 'active'], 'required'],
            [['validation_id', 'image_id'], 'integer'],
            [['active'], 'string'],
            [['date_created', 'date_updated'], 'safe'],
            [['validation_id', 'image_id'], 'unique', 'targetAttribute' => ['validation_id', 'image_id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['validation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Validation::className(), 'targetAttribute' => ['validation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'validation_id' => Yii::t('app', 'Validation'),
            'image_id' => Yii::t('app', 'Image'),
            'active' => Yii::t('app', 'Active'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[Image]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * Gets query for [[Validation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getValidation()
    {
        return $this->hasOne(Validation::className(), ['id' => 'validation_id']);
    }
}
