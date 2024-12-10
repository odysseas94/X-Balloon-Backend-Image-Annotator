<?php

namespace app\controllers\api\v1;
class GenericController extends \app\controllers\api\v1\BasicController
{


    public function actionGetUser()
    {
        return  ["success"=>$this->user];
    }


}