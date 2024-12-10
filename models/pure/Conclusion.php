<?php

namespace app\models\pure;

use app\models\Model;
use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "conclusion".
 *
 * @property int $id
 * @property int $shapes
 * @property float $average_detection
 * @property string $success_json
 * @property string $date_created
 * @property string $date_updated
 *
 * @property-read string $prettyName
 * @property TestingImages[] $testingImages
 */
class Conclusion extends Model
{
    /**
     * {@inheritdoc}
     */


    public $image_id;
    public $average;

    public static function tableName()
    {
        return 'conclusion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shapes', 'success_json'], 'required'],
            [['shapes'], 'integer'],
            [['average_detection'], 'number'],
            [['success_json'], 'string'],
            [['date_created', 'date_updated'], 'safe'],
        ];
    }


    public function getPrettyName()
    {

        return $this->shapes . " [" . Yii::t("app", "Average: " . $this->average_detection * 100 . "%]");


    }


    public function getAverage()
    {
        $average = 0;

        $success_json = Json::decode($this->success_json);
        foreach ($success_json as $value) $average += $value;
        $average /= count($success_json);
        return round($average, 2);
    }


    public function save($runValidation = true, $attributeNames = null)
    {


        $this->average_detection = $this->getAverage();
        return parent::save($runValidation, $attributeNames); // TODO: Change the autogenerated stub
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'shapes' => Yii::t('app', 'Shapes'),
            'average' => Yii::t('app', 'Average'),
            'average_detection' => Yii::t('app', 'Average'),
            'image_id' => Yii::t('app', 'Image'),
            'success_json' => Yii::t('app', 'Ratios'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[TestingImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTestingImages()
    {
        return $this->hasMany(TestingImages::className(), ['conclusion_id' => 'id']);
    }
}
