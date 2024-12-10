<?php

namespace app\models\pure;

use app\models\Model;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%shape}}".
 *
 * @property int $id
 * @property string $points
 * @property int $shape_type_id
 * @property int $class_id
 * @property double $area
 * @property string $date_created
 * @property string $date_updated
 *
 * @property ImageShape[] $imageShapes
 * @property Image[] $images
 * @property ShapeType $shapeType
 * @property Classification $class
 * @property ShapeCreator[] $shapeCreators
 * @property-read ActiveQuery $testing
 * @property-read ActiveQuery $image
 * @property ShapeType[] $users
 */
class Shape extends Model
{
    public static function tableName()
    {
        return '{{%shape}}';
    }

    public $temp_value;
    public $image_id;
    public $shape_deleted;
    public $shape_creator;
    public $testing_id;

    public function rules()
    {
        return [
            [['points', 'shape_type_id', 'class_id', "area"], 'required'],
            [['points'], 'string'],
            [['area'], 'number'],
            [['shape_type_id', 'class_id'], 'integer'],
            [['date_created', 'date_updated', 'date_born'], 'safe'],
            [['shape_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShapeType::className(), 'targetAttribute' => ['shape_type_id' => 'id']],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => Classification::className(), 'targetAttribute' => ['class_id' => 'id']],
        ];
    }

    public function getImageShapes()    
    {
        return $this->hasMany(ImageShape::className(), ['shape_id' => 'id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'points' => Yii::t('app', 'Points'),
            'area' => Yii::t('app', 'Area'),
            'shape_type_id' => Yii::t('app', 'Shape Type'),
            'testing_id' => Yii::t('app', 'Testing'),
            'class_id' => Yii::t('app', 'Classification'),
            'image_id' => Yii::t('app', 'Image'),
            'shape_deleted' => Yii::t('app', 'Deleted'),
            'shape_creator' => Yii::t('app', 'Creator'),
            'image_deleted' => Yii::t('app', 'Deleted'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * @return ActiveQuery
     */

    public function getImages()
    {
        return $this->hasMany(Image::className(), ['id' => 'image_id'])->viaTable('{{%image_shape}}', ['shape_id' => 'id']);
    }

    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id'])->viaTable('{{%image_shape}}', ['shape_id' => 'id']);

    }

    public function getAttributes($names = null, $except = array())
    {
        $result = parent::getAttributes($names, $except);
        if (!$this->isNewRecord) {

            $result["class"] = $this->class->name;
        }
        return $result;


    }


    /**
     * @return ActiveQuery
     */
    public function getTesting()
    {
        return $this->hasOne(Testing::className(), ['id' => 'testing_id'])->viaTable('{{%image_shape}}', ['shape_id' => 'id']);

    }

    /**
     * @return ActiveQuery
     */
    public function getShapeType()
    {
        return $this->hasOne(ShapeType::className(), ['id' => 'shape_type_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(Classification::className(), ['id' => 'class_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getShapeCreators()
    {
        return $this->hasMany(ShapeCreator::className(), ['shape_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(ShapeType::className(), ['id' => 'user_id'])->viaTable('{{%shape_creator}}', ['shape_id' => 'id']);
    }


    public static function getRestricted($user_id, $id)
    {
        return self::findBySql(" select shape.* from shape
    inner join shape_creator on shape_creator.shape_id=shape.id and 
                                (shape_creator.user_id='{$user_id}' or exists(select user_manager.user_id  from user_manager where shape_creator.user_id=user_manager.user_id and user_manager.manager_id='{$user_id}'))
    where shape.id=$id "
        )->one();
    }
}
