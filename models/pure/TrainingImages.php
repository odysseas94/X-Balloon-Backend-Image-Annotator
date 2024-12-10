<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "training_images".
 *
 * @property int $training_id
 * @property int $image_id
 * @property string $date_created
 * @property string $date_updated
 * @property string $active
 *
 * @property Image $image
 * @property Shape $training
 */
class TrainingImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'training_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_id', 'image_id', 'active'], 'required'],
            [['training_id', 'image_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['active'], 'string'],
            [['training_id', 'image_id'], 'unique', 'targetAttribute' => ['training_id', 'image_id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['training_id'], 'exist', 'skipOnError' => true, 'targetClass' => Training::className(), 'targetAttribute' => ['training_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'training_id' => Yii::t('app', 'Training'),
            'image_id' => Yii::t('app', 'Image'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
            'active' => Yii::t('app', 'Active'),
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
     * Gets query for [[Training]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTraining()
    {
        return $this->hasOne(Training::className(), ['id' => 'training_id']);
    }
}
