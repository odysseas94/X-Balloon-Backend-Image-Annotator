<?php

namespace app\helpers;

use app\models\pure\Shape;

class ImageStats
{
    public $image = null;
    public $testing_id = null;


    private $shapes = [];
    private $total_area = 0;
    private $areas = [];


    public function __construct($image, $testing_id)
    {
        $this->image = $image;
        $this->testing_id = $testing_id;


        $this->total_area = $image->width * $image->height;
    }


    public function init()
    {
        $testing_str = "and testing_id is null";
        if ($this->testing_id)
            $testing_str = "and testing_id=$this->testing_id";


        $shapes = Shape::findBySql("select shape.id,shape.points,shape.shape_type_id,shape.class_id,sum(shape.area) as area,shape.date_created,shape.date_updated
                                from shape 
                                inner join image_shape on image_shape.shape_id=shape.id and image_id={$this->image->id} and image_shape.deleted=0  $testing_str
                                
                                group by shape.class_id")->all();
        foreach ($shapes as $shape) {

            if ($shape->class->name != "area")
                $this->areas[$shape->class_id] = $shape;
            else {
                $this->total_area = $shape->area;

            }


        }


        foreach ($this->areas as $key => $shape) {
            $shape->temp_value = $this->total_area ? round(($shape->area / $this->total_area) * 100, 4) : 0;
            $shape->area = $this->total_area ? round(($shape->area / $this->total_area) * 100, 4) : 0;

        }


        return $this->areas;

    }


}