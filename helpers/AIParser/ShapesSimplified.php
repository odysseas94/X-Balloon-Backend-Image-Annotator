<?php

namespace app\helpers\AIParser;

use app\models\pure\Classification;
use app\models\pure\Image;
use app\models\pure\Shape;
use app\models\pure\ShapeType;
use yii\helpers\ArrayHelper;

class ShapesSimplified
{

    private $images = [];
    private $shapes = [];
    private $result = [];

    public $shapes_types = [];
    public $classifications = [];

    public $images_result = [];

    public $images_counters = [];


    public function __construct($images, $classifications_ids = null)
    {
        $classification_appender = "";
        if ($classifications_ids && count($classifications_ids)) {
            $classification_appender = " and shape.class_id in (" . implode(",", $classifications_ids) . ")";
        }
        if (count($images)) {


            $this->images = $images;
            $ids = ArrayHelper::map($this->images, "id", "id");
            $this->shapes = Shape::findBySql("select shape.*,image.id as temp_value from shape
                  inner join image_shape on image_shape.shape_id=shape.id and deleted=0 and image_shape.testing_id is null
                  inner join image on image.id=image_shape.image_id and visible=1
                       where image.id in (" . implode(",", $ids) . ") $classification_appender")->all();


            foreach (ShapeType::find()->all() as $shape)
                $this->shapes_types[$shape->id] = $shape;
            foreach (Classification::find()->all() as $classification)
                $this->classifications[$classification->id] = $classification;
        }

    }


    public function init()
    {


        foreach ($this->images as $image) {

            $this->result[$image->id] = ["image" => $image->getAttributes(), "shapes" => [],
            ];

            $this->images_result[$image->id] = [];
            $this->images_counters[$image->id] = 1;
        }

        foreach ($this->shapes as $shape) {


            try {
                $simpleShape = new SimpleShape($this, $shape);

//                    $this->images_result[$shape->temp_value] [$this->images_counters[$image->id]++] = $simpleShape->init();
                array_push($this->images_result[$shape->temp_value], $simpleShape->init());


            } catch (\Exception $e) {
//                die(json_encode($e->getTraceAsString()).json_encode($shape->id));
            }


        }


        foreach ($this->images as $image) {

            $this->result[$image->id] = [

                "fileref" => $image->getFullImagePath(),

                "size" => $image->size,
                "image_attributes" => $image->getAttributes(),
                "filename" => basename($image->path),
                "base64_img_data" => "",
                "file_attributes" => "{}",
                "regions" => $this->images_result[$image->id],


            ];
        }



        return $this->result;


    }


}




