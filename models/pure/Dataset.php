<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "dataset".
 *
 * @property int $id
 * @property string $name
 * @property int $training_id
 * @property int $validation_id
 * @property int $status_id
 * @property string $date_created
 * @property string $date_updated
 *
 * @property AIStatus $status
 * @property Training $training
 * @property Validation $validation
 */
class Dataset extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dataset';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'training_id', 'validation_id', 'status_id'], 'required'],
            [['training_id', 'validation_id', 'status_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['name'], 'string', 'max' => 512],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => AIStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['training_id'], 'exist', 'skipOnError' => true, 'targetClass' => Training::className(), 'targetAttribute' => ['training_id' => 'id']],
            [['validation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Validation::className(), 'targetAttribute' => ['validation_id' => 'id']],
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
            'training_id' => Yii::t('app', 'Training'),
            'validation_id' => Yii::t('app', 'Validation'),
            'status_id' => Yii::t('app', 'Status'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
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






//    public function getPrettyName(){
//
//        $append = "";
//        if ($model = TrainingWeights::findBySql("select * from training_weights where training_id=$this->training_id")->one()) {
//            $append = " " . $model->getPrettyName()."";
//        }
//        return $this->name.$append;
//    }


    public function getPrettyName()
    {
        return $this->name;
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
