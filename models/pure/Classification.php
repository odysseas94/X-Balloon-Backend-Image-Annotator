<?php

namespace app\models\pure;

use app\models\Model;
use Yii;

/**
 * This is the model class for table "{{%classification}}".
 *
 * @property int $id
 * @property string $name
 * @property string $pretty_name
 * @property string $color
 * @property string $visible
 * @property string $date_created
 * @property string $date_updated
 *
 * @property Shape[] $shapes
 */
class Classification extends Model
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%classification}}';
    }


    public function getPrettyName()
    {
        return Yii::t("app", $this->pretty_name);

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'pretty_name', 'color', 'visible'], 'required'],
            [['date_created', 'date_updated'], 'safe'],
            [['name', 'pretty_name'], 'string', 'max' => 128],
            [['color'], 'string', 'max' => 15],
            [['visible'], 'string'],
            [['name'], 'unique'],
            [['pretty_name'], 'unique'],
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
            'visible' => Yii::t('app', 'Visible'),
            'pretty_name' => Yii::t('app', 'Pretty Name'),
            'color' => Yii::t('app', 'Color'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShapes()
    {
        return $this->hasMany(Shape::className(), ['class_id' => 'id']);
    }
}
