<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "user_config".
 *
 * @property int $user_id
 * @property int|null $language_id
 * @property int|null $attribute_parser_image_id
 * @property int|null $image_testing_id
 * @property string $date_created
 * @property string $date_updated
 *
 * @property User $user
 * @property Country $language
 * @property Image $attributeParserImage
 */
class UserConfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'language_id', 'attribute_parser_image_id', 'image_testing_id'], 'integer'],
            [['date_created', 'date_updated'], 'safe'],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['attribute_parser_image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['attribute_parser_image_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'image_testing_id' => Yii::t('app', 'Image Testing '),
            'attribute_parser_image_id' => Yii::t('app', 'Attribute Parser Image ID'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_updated' => Yii::t('app', 'Date Updated'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[AttributeParserImage]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeParserImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'attribute_parser_image_id']);
    }

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Country::className(), ['id' => 'language_id']);
    }

    /**
     * Gets query for [[Testing]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImageTesting()
    {
        return $this->hasOne(Testing::className(), ['id' => 'image_testing_id']);
    }
}
