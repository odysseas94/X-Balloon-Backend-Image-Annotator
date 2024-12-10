<?php

namespace app\controllers;

use Yii;
use yii\web\ForbiddenHttpException;
/**
 *
 * @property void onlyAdmin
 * @property void onlyManager
 */
class AuthedController extends CController
{
    protected $for_admin = false;
    protected $for_manager = false;
    protected $rbac_pass = false;


    public function beforeAction($action): bool
    {

        if (!parent::beforeAction($action))
            return false;
        if (Yii::$app->user->isGuest) {
            $this->redirect(['site/login']);

            return false;
        }

        $this->is_logged = true;


        $this->user = Yii::$app->user->identity;


        $this->checkUserPermissions();
        $this->checkPermissionsRBAC();
        $this->setLayout();
        return true;
    }

    private function checkUserPermissions()
    {
        if ($this->for_admin)
            $this->onlyAdmin;
        if ($this->for_manager)
            $this->onlyManager;
    }


    /**
     * @throws ForbiddenHttpException
     */
    public function getOnlyAdmin()
    {
        if (!$this->user->isAdmin) {
            $this->forbid();
        }
    }

    public function getOnlyManager()
    {
        if (!($this->user->isManager || $this->user->isAdmin)) {
            $this->forbid();
        }

    }


    //all perimisions shall have <controller>/<name>
    private function checkPermissionsRBAC()
    {
        $this->controller_name = !$this->controller_name ? Yii::$app->controller->id : $this->controller_name;
        $action_name = Yii::$app->controller->action->id;
        $action = $this->controller_name . "/" . $action_name;
        if (\Yii::$app->user->can($action)) {

            throw new \yii\web\ForbiddenHttpException($action);
        }
    }


    public function actionOnDelete()
    {


        if (Yii::$app->request->referrer) {
            $query = null;
            parse_str(parse_url(Yii::$app->request->referrer)['query'], $query);
            $r = $query["r"];
            if (strpos($r, "/index") !== false) {
                return $this->goBack(Yii::$app->request->referrer);
            }
        }

        return $this->redirect(["index"]);
    }
}