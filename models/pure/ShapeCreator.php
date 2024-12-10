<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "{{%shape_creator}}".
 *
 * @property int $user_id
 * @property int $shape_id
 *
 * @property Shape $shape
 * @property ShapeType $user
 */
class ShapeCreator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shape_creator}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'shape_id'], 'required'],
            [['user_id', 'shape_id'], 'integer'],
            [['user_id', 'shape_id'], 'unique', 'targetAttribute' => ['user_id', 'shape_id']],
            [['shape_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shape::className(), 'targetAttribute' => ['shape_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User'),
            'shape_id' => Yii::t('app', 'Shape'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShape()
    {
        return $this->hasOne(Shape::className(), ['id' => 'shape_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
