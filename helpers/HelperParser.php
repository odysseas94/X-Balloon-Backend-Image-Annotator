<?php

namespace app\helpers;

use Yii;

class HelperParser
{
    public $result = [];
    public $user = null;


    public function __construct($user = null)
    {

        if (!$user)
            $this->user = Yii::$app->user->identity;
        else
            $this->user = $user;


    }

    public function init()
    {

    }


}