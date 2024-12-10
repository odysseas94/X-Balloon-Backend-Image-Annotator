<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "weight_file".
 *
 * @property int $id
 * @property string $name
 * @property string $configuration
 * @property float $success_ratio
 * @property float $error_ratio
 * @property float $val_loss
 * @property float $val_rpn_class_loss
 * @property float $val_rpn_bbox_loss
 * @property float $val_mrcnn_class_loss
 * @property float $val_mrcnn_bbox_loss
 * @property float $val_mrcnn_mask_loss
 * @property float $rpn_class_loss
 * @property float $rpn_bbox_loss
 * @property float $mrcnn_class_loss
 * @property float $mrcnn_bbox_loss
 * @property float $mrcnn_mask_loss
 * @property string|null $path
 * @property string $date_created
 * @property string $date_updated
 *
 * @property TrainingWeights[] $trainingWeights
 * @property string $prettyName
 * @property TrainingWeights[] $trainingWeights0
 */
class WeightFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'weight_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'success_ratio', 'error_ratio'], 'required'],
            [['success_ratio', 'error_ratio', 'val_loss', 'val_rpn_class_loss', 'val_rpn_bbox_loss', 'val_mrcnn_class_loss', 'val_mrcnn_bbox_loss', 'val_mrcnn_mask_loss', 'rpn_class_loss', 'rpn_bbox_loss', 'mrcnn_class_loss', 'mrcnn_bbox_loss', 'mrcnn_mask_loss'], 'number'],
            [['date_created', 'date_updated'], 'safe'],
            [['configuration'], 'string'],
            [['name'], 'string', 'max' => 127],
            [['path'], 'string', 'max' => 512],
        ];
    }

    public function getPrettyName()
    {
        return "$this->name [" . Yii::t('app', 'Success') . " $this->success_ratio%]";
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'success_ratio' => Yii::t('app', 'Success Ratio'),
            'configuration' => Yii::t('app', 'Configuration'),
            'error_ratio' => Yii::t('app', 'Error Ratio'),
            'val_loss' => Yii::t('app', 'Val Loss'),
            'val_rpn_class_loss' => Yii::t('app', 'Val Rpn Class Loss'),
            'val_rpn_bbox_loss' => Yii::t('app', 'Val Rpn Bbox Loss'),
            'val_mrcnn_class_loss' => Yii::t('app', 'Val Mrcnn Class Loss'),
            'val_mrcnn_bbox_loss' => Yii::t('app', 'Val Mrcnn Bbox Loss'),
            'val_mrcnn_mask_loss' => Yii::t('app', 'Val Mrcnn Mask Loss'),
            'rpn_class_loss' => Yii::t('app', 'Rpn Class Loss'),
            'rpn_bbox_loss' => Yii::t('app', 'Rpn Bbox Loss'),
            'mrcnn_class_loss' => Yii::t('app', 'Mrcnn Class Loss'),
            'mrcnn_bbox_loss' => Yii::t('app', 'Mrcnn Bbox Loss'),
            'mrcnn_mask_loss' => Yii::t('app', 'Mrcnn Mask Loss'),
            'path' => Yii::t('app', 'Path'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[TrainingWeights]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingWeights()
    {
        return $this->hasMany(TrainingWeights::className(), ['weight_child_id' => 'id']);
    }

    /**
     * Gets query for [[TrainingWeights0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingWeights0()
    {
        return $this->hasMany(TrainingWeights::className(), ['weight_parent_id' => 'id']);
    }
}
