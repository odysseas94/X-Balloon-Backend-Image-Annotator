<?php

namespace app\controllers;

use app\models\pure\Machine;
use app\models\pure\MachineStatus;
use Yii;

class SocketController extends AuthedController
{


    public $for_admin = true;

    public function actionIndex()
    {

        $machines = Machine::find()->all();


        $page = "machines";
        return $this->render("index", [
            "user" => $this->user,
            "models" => $machines,

            "page" => $page
        ]);
    }

    public function actionSetAllMachinesStatus($name)
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $machineStatus = MachineStatus::findOne(["name" => $name]);
        if ($machineStatus) {


            $saved = Yii::$app->db->createCommand("update machine set machine_status_id=$machineStatus->id")->execute();

            return ["success" => "updated"];


        }

        return ["error" => "couldn't find machine status $name",
        ];


    }
}