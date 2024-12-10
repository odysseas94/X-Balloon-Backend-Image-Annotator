<?php

namespace app\controllers;

class WorkbenchController extends AuthedController
{
    public $layout = "workbench";

    public function actionIndex()
    {



        return $this->render('index');
    }

}
