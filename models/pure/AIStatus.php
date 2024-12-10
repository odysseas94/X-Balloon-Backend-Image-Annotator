<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "ai_status".
 *
 * @property int $id
 * @property string $name
 * @property string $date_created
 * @property string $date_updated
 *
 * @property Dataset[] $datasets
 * @property Training[] $trainings
 */
class AIStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ai_status';
    }


    public function getHtmlLabeled()
    {
        if ($this->name === "pending")
            return "btn-warning";
        else if ($this->name === "running")
            return "btn-outline-brand";
        else
            return "brn-success";

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date_created', 'date_updated'], 'safe'],
            [['name'], 'string', 'max' => 127],
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
        return $this->hasMany(Dataset::className(), ['status_id' => 'id']);
    }


    public function getPrettyName()
    {
        return Yii::t("app", $this->name);

    }

    /**
     * Gets query for [[Trainings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrainings()
    {
        return $this->hasMany(Training::className(), ['status_id' => 'id']);
    }
}
