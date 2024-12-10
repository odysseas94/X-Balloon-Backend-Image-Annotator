<?php

namespace app\helpers;

use app\models\pure\Shape;
use yii\helpers\Json;

class AttributeParser extends AttributeParent
{

    private $shapeResult = [];

    public $testing_id = null;


    public function __construct($user, $image)
    {
        parent::__construct($user);

        if (!($image instanceof \app\models\pure\Image))
            throw new \Exception("Image not set");
        $this->image = $image;
        $this->image_id = $image->id;

    }

    public function init()
    {
        $this->jsonResult["shapes"] = [];

        if ($this->findShapes())
            $this->normalizeToJson();
        return $this->jsonResult;


    }

    public function findShapes()
    {
        $testing_str = " and testing_id is null";
       if($this->testing_id)
           $testing_str = " and testing_id=$this->testing_id";
        $this->shapes = Shape::findBySql("select shape.* from shape
          inner join image_shape on image_shape.shape_id=shape.id and image_id={$this->image->id} and image_shape.deleted=0 $testing_str")->all();

        return count($this->shapes) > 0;
    }

    public function normalizeToJson()
    {
        foreach ($this->shapes as $shape) {
            $attributes = $shape->getAttributes();

            array_push($this->shapeResult, $attributes);
        }
        $this->jsonResult["shapes"] = $this->shapeResult;
        return true;
    }

}

?>
