<?php

namespace app\helpers\AIParser;

use app\models\pure\Shape;
use yii\helpers\Json;

class SimpleShape
{

    private $shapesSimplified = null;
    public $classifications;
    public $classification;
    public $shapeTypes;
    public $shapeType;
    public $shapeModel;

    public $points = null;
    public $result = [
        "shape_attributes" => [],
        "region_attributes" => []];


    public function __construct($shapesSimplified, $shapeModel)

    {


        if (!($shapesSimplified instanceof ShapesSimplified && $shapeModel instanceof Shape)) {
            throw new \Exception("wrong params");
        }
        $this->shapesSimplified = $shapesSimplified;


        $this->shapeModel = $shapeModel;
        $this->points = Json::decode($shapeModel->points);
        $this->classifications = $shapesSimplified->classifications;
        $this->shapeTypes = $shapesSimplified->shapes_types;
        $this->classification = $this->classifications[$this->shapeModel->class_id];
        $this->shapeType = $this->shapeTypes[$this->shapeModel->shape_type_id];


    }


    public function init()
    {
        $this->result["region_attributes"] = [

            "name" => $this->classification->name,
            "id" => $this->classification->id,
        ];


        switch ($this->shapeType->name) {

            case "rectangle":
                $this->rectangle();
                break;
            case "circle":
                $this->circle();
                break;
            case "ellipse":
                $this->ellipse();
                break;
            case "polygon":
                $this->polygon();
                break;
            case "multipolygon":
                $this->multipolygon();
                break;
            default:
                throw new \Exception("shape not found");

        }
        return $this->result;

    }


    public function rectangle()
    {
        $this->result["shape_attributes"] = [

            "name" => "rect",
            "x" => $this->points["x"],
            "y" => $this->points["y"],
            "width" => $this->points["width"],
            "height" => $this->points["height"],


        ];


    }


    public function circle()
    {
        $this->result["shape_attributes"] = [

            "name" => "circle",
            "cx" => $this->points["x"],
            "cy" => $this->points["y"],
            "r" => $this->points["radius"],


        ];


    }


    public function ellipse()
    {
        $this->result["shape_attributes"] = [

            "name" => "ellipse",
            "cx" => $this->points["x"],
            "cy" => $this->points["y"],
            "rx" => $this->points["radius_x"],
            "ry" => $this->points["radius_y"],


        ];
    }

    public function polygon()
    {
        $xs = [];
        $ys = [];

        foreach ($this->points as $point) {
            array_push($xs, $point['x']);
            array_push($ys, $point['y']);
        }
//        array_push($xs, $this->points[0]['x']);
//        array_push($ys, $this->points[0]['y']);
        $this->result["shape_attributes"] = [

            "name" => "polygon",
            "all_points_x" => $xs,
            "all_points_y" => $ys
        ];


    }

    public function multipolygon()
    {
        $xs = [];
        $ys = [];

        foreach ($this->points as $point) {
            array_push($xs, $point['x']);
            array_push($ys, $point['y']);
        }

        $this->result["shape_attributes"] = [

            "name" => "multipolygon",
            "all_points_x" => $xs,
            "all_points_y" => $ys
        ];


    }
}
