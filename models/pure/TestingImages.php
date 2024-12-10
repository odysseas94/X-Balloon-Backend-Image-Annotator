<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "testing_images".
 *
 * @property int $testing_id
 * @property int $image_id
 * @property int $status_id
 * @property int|null $conclusion_id
 * @property string $date_created
 * @property string $date_updated
 *
 * @property Image $image
 * @property Testing $testing
 * @property AiStatus $status
 * @property Conclusion $conclusion
 */
class TestingImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'testing_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['testing_id', 'image_id', 'status_id'], 'required'],
            [['testing_id', 'image_id', 'status_id', 'conclusion_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['testing_id', 'image_id'], 'unique', 'targetAttribute' => ['testing_id', 'image_id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['testing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testing::className(), 'targetAttribute' => ['testing_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => AIStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['conclusion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conclusion::className(), 'targetAttribute' => ['conclusion_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'testing_id' => Yii::t('app', 'Testing'),
            'image_id' => Yii::t('app', 'Image'),
            'status_id' => Yii::t('app', 'Status'),
            'conclusion_id' => Yii::t('app', 'Conclusion'),
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
     * Gets query for [[Testing]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTesting()
    {
        return $this->hasOne(Testing::className(), ['id' => 'testing_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(AIStatus::className(), ['id' => 'status_id']);
    }

    /**
     * Gets query for [[Conclusion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConclusion()
    {
        return $this->hasOne(Conclusion::className(), ['id' => 'conclusion_id']);
    }
}
