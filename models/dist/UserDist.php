<?php

namespace app\models\dist;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author odyss
 */

use app\models\pure\User;
use Yii;
use yii\web\UploadedFile;

class UserDist extends User
{

    //put your code here

    private $image_found = false;


    public function save($runValidation = true, $attributeNames = null)
    {

        $str = null;
        if ($this->password) {


            $this->setPassword($this->password);
            $this->generateAuthKey();
            $this->token = Yii::$app->security->generateRandomString();

        }



        $this->status = self::STATUS_ACTIVE;
        $image = $this->imageInstance();


        if (UploadedFile::getInstance($image, 'image')) {


            if ($image->save())
                $this->image_id = $image->id;
//            else
//                die(json_encode($image->getErrors()));

        }


        return  parent::save();


    }

}
