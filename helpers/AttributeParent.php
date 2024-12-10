<?php

namespace app\helpers;

use \app\models\pure\User;
class AttributeParent{

    public $user=null;
    protected $user_id=null;
    public $image=null;
    protected $image_id=null;
    public $imageShapes=null;
    public $shapes=[];
    public $ready=false;
    public $jsonResult=null;

    public $errors=[];

    public function __construct($user) {

        if(!($user instanceof User)){
            throw new \Exception("User is not set");
        }
        $this->user=$user;
        $this->user_id=$user->id;

    }
}

?>
