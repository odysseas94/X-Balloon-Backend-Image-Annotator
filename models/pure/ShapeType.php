<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "{{%shape_type}}".
 *
 * @property int $id
 * @property string $name
 * @property string $pretty_name
 * @property string $date_created
 * @property string $date_updated
 *
 * @property Shape[] $shapes
 * @property ShapeCreator[] $shapeCreators
 * @property Shape[] $shapes0
 */
class ShapeType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shape_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'pretty_name'], 'required'],
            [['date_created', 'date_updated'], 'safe'],
            [['name', 'pretty_name'], 'string', 'max' => 128],
            [['pretty_name'], 'unique'],
            [['name'], 'unique'],
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
            'pretty_name' => Yii::t('app', 'Pretty Name'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShapes()
    {
        return $this->hasMany(Shape::className(), ['shape_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShapeCreators()
    {
        return $this->hasMany(ShapeCreator::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShapes0()
    {
        return $this->hasMany(Shape::className(), ['id' => 'shape_id'])->viaTable('{{%shape_creator}}', ['user_id' => 'id']);
    }
}
