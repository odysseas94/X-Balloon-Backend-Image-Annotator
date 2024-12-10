<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "{{%image_shape}}".
 *
 * @property int $image_id
 * @property int $shape_id
 * @property int $deleted
 * @property int|null $testing_id testing created this attribute
 * @property string $date_created
 * @property string $date_updated
 *
 * @property Image $image
 * @property Shape $shape
 */
class ImageShape extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%image_shape}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_id', 'shape_id'], 'required'],
            [['image_id', 'shape_id', 'deleted', 'testing_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['image_id', 'shape_id'], 'unique', 'targetAttribute' => ['image_id', 'shape_id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
            [['shape_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shape::className(), 'targetAttribute' => ['shape_id' => 'id']],
            [['testing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testing::className(), 'targetAttribute' => ['testing_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'image_id' => Yii::t('app', 'Image'),
            'shape_id' => Yii::t('app', 'Shape'),
            'testing_id' => Yii::t('app', 'testing created this attribute'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
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
    public function getShape()
    {
        return $this->hasOne(Shape::className(), ['id' => 'shape_id']);
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
}
