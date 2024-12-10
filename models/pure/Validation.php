<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "validation".
 *
 * @property int $id
 * @property string $name
 * @property string $logs
 * @property string $date_created
 * @property string $date_updated
 *
 * @property Dataset[] $datasets
 * @property ValidationImages[] $validationImages
 * @property Image[] $images
 */
class Validation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'validation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'logs'], 'required'],
            [['logs'], 'string'],
            [['date_created', 'date_updated'], 'safe'],
            [['name'], 'string', 'max' => 512],
        ];
    }


    public function getPrettyName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'logs' => Yii::t('app', 'Comments'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[Datasets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDatasets()
    {
        return $this->hasMany(Dataset::className(), ['validation_id' => 'id']);
    }

    /**
     * Gets query for [[ValidationImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getValidationImages()
    {
        return $this->hasMany(ValidationImages::className(), ['validation_id' => 'id']);
    }

    /**
     * Gets query for [[Images]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['id' => 'image_id'])->viaTable('validation_images', ['validation_id' => 'id']);
    }
}
