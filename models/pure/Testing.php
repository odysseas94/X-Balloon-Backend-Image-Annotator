<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "testing".
 *
 * @property int $id
 * @property string $name
 * @property int $dataset_id
 * @property int $status_id
 * @property string $active
 * @property string $description
 * @property string $date_created
 * @property string $date_updated
 *
 * @property AIStatus $status
 * @property Dataset $dataset
 * @property TestingImages[] $testingImages
 * @property Image[] $images
 */
class Testing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'testing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'dataset_id', 'status_id'], 'required'],
            [['dataset_id', 'status_id'], 'integer'],
            [['active', 'description'], 'string'],
            [['date_created', 'date_updated'], 'safe'],
            [['name'], 'string', 'max' => 128],
            [['name'], 'unique'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => AIStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['dataset_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dataset::className(), 'targetAttribute' => ['dataset_id' => 'id']],
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
            'dataset_id' => Yii::t('app', 'Dataset'),
            'status_id' => Yii::t('app', 'Status'),
            'active' => Yii::t('app', 'Active'),
            'description' => Yii::t('app', 'Description'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }


    public function getPrettyName()
    {

        return $this->name." : ".$this->dataset->prettyName."";
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
     * Gets query for [[Dataset]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataset()
    {
        return $this->hasOne(Dataset::className(), ['id' => 'dataset_id']);
    }

    /**
     * Gets query for [[TestingImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTestingImages()
    {
        return $this->hasMany(TestingImages::className(), ['testing_id' => 'id']);
    }

    /**
     * Gets query for [[Images]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['id' => 'image_id'])->viaTable('testing_images', ['testing_id' => 'id']);
    }
}
