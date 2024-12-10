<?php

namespace app\helpers\Override;

use yii\widgets\ActiveField;


class ActiveForm extends \yii\widgets\ActiveForm
{

    private $_fields = [];
    public $fieldClass = 'app\helpers\Override\ActiveField';
}