<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 *
 * @property-read string $prettyName
 */
class Model extends ActiveRecord
{

    public $counter;
    public $average;
    public $total;

    public static function getAllRestricted($user_id = null)
    {
        $user_id = $user_id ? $user_id : $user_id = Yii::$app->user->identity->id;

        return self::find()->all();

    }


    public static function getAllRestrictedCurrent()
    {

        return self::find()->all();
    }

    public function getPrettyName()
    {
        return "";
    }

}