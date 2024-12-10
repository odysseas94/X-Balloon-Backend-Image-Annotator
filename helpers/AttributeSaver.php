<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\helpers;

use app\models\pure\Image;
use app\models\pure\ImageShape;
use app\models\pure\Shape;
use app\models\pure\ShapeCreator;
use Yii;
use yii\db\Exception;

/**
 * Description of AttributeSaver
 *
 * @author odyss
 */
class AttributeSaver extends AttributeParent
{

    private $request = null;

    private $result = [];
    public $testing_id = null;

    public function __construct($user, $image, $request)
    {
        parent::__construct($user);

        if (!$this->isArray($request)) {
            throw new \Exception("request is not array");
        }

        if (!($image instanceof Image)) {
            throw new \Exception("image not an Image instance");
        }
        $this->image = $image;


        $this->request = $request;
    }

    public function init()
    {
        if ($this->saveAllModels()) {

            return $this->result;
        } else
            throw new \Exception(json_encode($this->errors));
    }

    function isArray($string)
    {

        return is_array($string);
    }

    function isJson($json)
    {
        json_decode($json);
        if (json_last_error() === JSON_ERROR_NONE) {
            return true;
        }
        return false;
    }


    public function saveImageShape($found, $deleted, $image, $shape)
    {
        if (!($image_shape = ImageShape::findBySql("select * from image_shape where image_id={$image->id} and shape_id=$shape->id")->one()))
            $image_shape = new ImageShape();
        $image_shape->image_id = $image->id;
        $image_shape->shape_id = $shape->id;
        if ($this->testing_id)
            $image_shape->testing_id = $this->testing_id;

        $image_shape->deleted = $deleted;
        if ($image_shape->save()) {
            if (!$found) {
                $shape_creator = new ShapeCreator();
                $shape_creator->shape_id = $shape->id;

                $shape_creator->user_id = $this->user->id;

                if (!$shape_creator->save())
                    throw new \Exception($shape_creator->getFirstErrors());


            }
        } else

            throw new \Exception($image_shape->getFirstErrors());
    }

    function saveAllModels()
    {

        $request = $this->request;
        $image = $this->image;
        $this->errors = [];
        if (isset($request["shapes"]) && is_array($request["shapes"])) {


            $shapes = $request["shapes"];

            $deleted = 0;

            foreach ($shapes as $array_shape) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $array_shape["points"] = is_array($array_shape["points"]) ? json_encode($array_shape["points"]) : $array_shape["points"];
                    $found = false;
                    $shape = new Shape();

                    if (isset($array_shape["id"]) && $array_shape["id"]) {


                        $shape = Shape::findBySql("select shape.* from shape 
inner join image_shape on image_shape.image_id=$image->id 
where shape.id={$array_shape["id"]}")->one();
                        if (!$shape)
                            $shape = new Shape();
                        else {
                            $found = true;
                            if (isset($array_shape["deleted"]))
                                $deleted = intval($array_shape["deleted"]);
                        }
                    }
                    $shape->setAttributes($array_shape);

                    $shape->area = floor($shape->area * 100) / 100;

                    if (!$this->isJson($shape->points)) {
                        throw new Exception("points are not json");

                    }

//                    die(json_encode($shape->getAttributes()));

                    if ($shape->save()) {

                        if (!$found || $deleted) {

                            $this->saveImageShape($found, $deleted, $image, $shape);

                        }
                    } else {
                        throw new \Exception($shape->getFirstErrors());
                    }

                    $transaction->commit();

                    array_push($this->shapes, $shape);
                    if (isset($array_shape["_id"])) {
                        $this->result[$array_shape["_id"]] = $shape;
                    }
                } catch (\Exception $e) {

                    array_push($this->errors, $e->getMessage());
                    $transaction->rollBack();

                }
            }


        } else array_push($this->errors, "array is empty");


        return empty($this->errors);

    }


}
