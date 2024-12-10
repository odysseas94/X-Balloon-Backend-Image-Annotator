<?php

namespace app\helpers;

use app\models\pure\Classification;

class DashboardAdminHelper
{
    public static function shapeClassesGroupByDateJSON()
    {
        $models = \app\models\pure\Shape::findBySql("select count(*) as id,cast(shape.date_created as DATE ) as date_created,shape.class_id,shape.shape_type_id from shape
     inner join image_shape on image_shape.shape_id=shape.id and deleted=0 and testing_id is null   
    where shape.date_created >   DATE_SUB(CURDATE(), INTERVAL 15 DAY) 
    group by CAST(date_created AS DATE),class_id
    
    order by date_created ")->all();
        $result = [];
        foreach ($models as $model) {

            if (!isset($result[$model->class_id]))
                $result[$model->class_id] = [];
            $result[$model->class_id] [] = ["count" => $model->id, "date" => $model->date_created];
        }
        $final_array = [];
        foreach ($result as $key => $model) {
            $classification = Classification::findOne($key);

            $final_array[$classification->name]["values"] = $model;
            $final_array[$classification->name]["pretty_name"] = $classification->pretty_name;
            $final_array[$classification->name]["color"] = $classification->color;
        }
        return json_encode($final_array);
    }
    public static function shapeClassesJSON()
    {
        $models = \app\models\pure\Shape::findBySql("select count(*) as id,shape.class_id as date_created,shape.class_id,shape.shape_type_id
       from shape
     inner join image_shape on image_shape.shape_id=shape.id and deleted=0 and testing_id is null  
    group by class_id")->all();
        $result = [];
        $classifications = Classification::find()->all();

        foreach ($classifications as $classification) {
            $result[$classification->id] = array_merge($classification->getAttributes(), ["count" => 0]);
        }
        foreach ($models as $model) {


            $result[$model->class_id] = array_merge(
                $result[$model->class_id], ["count" => $model->id]);

        }


        return json_encode(array_values($result));
    }

    public static function shapeClassesAutomatedJSON()
    {
        $models = \app\models\pure\Shape::findBySql("select count(*) as id,shape.class_id as date_created,shape.class_id,shape.shape_type_id
       from shape
     inner join image_shape on image_shape.shape_id=shape.id and deleted=0 and testing_id is not null  
    group by class_id")->all();

        $result = [];

        $classifications = Classification::find()->all();

        foreach ($classifications as $classification) {
            $result[$classification->id] = array_merge($classification->getAttributes(), ["count" => 0]);
        }
        foreach ($models as $model) {


            $result[$model->class_id] = array_merge(
                $result[$model->class_id], ["count" => $model->id]);

        }


        return json_encode(array_values($result));
    }

}