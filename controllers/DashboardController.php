<?php

namespace app\controllers;


use app\helpers\DashboardAdminHelper;
use app\models\pure\Conclusion;
use Yii;

/**
 *
 * @property-read mixed $previousConclusionsByDateJSON
 */
class DashboardController extends AuthedController
{
    public function actionManager()
    {
        return $this->render('manager');

    }

    public function actionAdmin()

    {


        $shapesCount = DashboardAdminHelper::shapeClassesJSON();
        $shapesCountByDate = DashboardAdminHelper::shapeClassesGroupByDateJSON();
        $allConclusionsByDate = $this->getPreviousConclusionsByDateJSON();


        return $this->render('admin', [
            "shapesCount" => $shapesCount,
            "shapesCountAutomated" => DashboardAdminHelper::shapeClassesAutomatedJSON(),
            "shapesContByDate" => $shapesCountByDate,
            "allConclusionsByDate" => $allConclusionsByDate
        ]);

    }


    public function actionIndex()
    {
        if ($this->user->isAdmin) {
            return Yii::$app->response->redirect(['dashboard/admin']);
        } else if ($this->user->isManager)
            return Yii::$app->response->redirect(['dashboard/admin']);
    }


    public function actionLocale($name)
    {
        $this->setLocale($name);


        return isset($_SERVER['HTTP_REFERER']) ? $this->redirect($_SERVER['HTTP_REFERER']) : $this->redirect(Yii::$app->homeUrl);


    }


    private function getPreviousConclusionsByDateJSON()
    {
        $previousTestings = Conclusion::findBySql("select round(avg(conclusion.average_detection)*100,2) as average_detection,avg(conclusion.shapes) as shapes,date(if(conclusion.date_updated is null  or conclusion.date_updated =0,conclusion.date_created,conclusion.date_updated)) as date_created,count(conclusion.id) as counter  from conclusion
inner join testing_images on testing_images.conclusion_id=conclusion.id
group by testing_images.testing_id
order by date_created desc
limit 30")->all();

        $result = [];
        foreach ($previousTestings as $model) {
            $result[] = ["date" => $model->date_created, "percentage" => $model->average_detection, "counter" => $model->counter, "shapes" => $model->shapes,
            ];
        }

        return json_encode($result);
    }
}
