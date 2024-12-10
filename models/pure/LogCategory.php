<?php

namespace app\models\pure;

use Yii;

/**
 * This is the model class for table "log_category".
 *
 * @property int $id
 * @property string $name
 * @property string $pretty_name
 * @property string|null $description
 * @property string $date_created
 * @property string|null $date_updated
 *
 * @property Log[] $logs
 */
class LogCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'pretty_name'], 'required'],
            [['description'], 'string'],
            [['date_created', 'date_updated'], 'safe'],
            [['name', 'pretty_name'], 'string', 'max' => 127],
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
            'id' => 'ID',
            'name' => 'Name',
            'pretty_name' => 'Pretty Name',
            'description' => 'Description',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        ];
    }

    /**
     * Gets query for [[Logs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Log::className(), ['log_category_id' => 'id']);
    }
}
