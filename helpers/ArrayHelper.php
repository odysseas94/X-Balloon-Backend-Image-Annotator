<?php

namespace app\helpers;
class ArrayHelper extends \yii\helpers\ArrayHelper
{
    public static function keys($array = [], $key)
    {

        $result = [];
        foreach ($array as $element) {


            $result[] = static::getValue($element, $key);

        }

        return $result;
    }


    public static function implodeKeys($glue, $array, $key)
    {
        return implode($glue, static::keys($array, $key));
    }


}