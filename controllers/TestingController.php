<?php

namespace app\controllers;

use app\models\search\DatasetConfigurationSearch;
use app\models\search\TestingConfigurationSearch;
use Yii;
use app\models\pure\Testing;
use app\models\search\TestingSearch;
use app\controllers\CController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestingController implements the CRUD actions for Testing model.
 */
class TestingController extends AuthedController
{
    /**
     * {@inheritdoc}
     */

    public $for_admin = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Testing models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Testing model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Testing model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Testing();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Testing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Testing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $this->findModel($id)->delete();


        return $this->actionOnDelete();
    }

    public function actionConfiguration($id)
    {

        $testing = $this->findModel($id);
        $searchModel = new TestingConfigurationSearch();
        $searchModel->testing_id = $id;
        $searchModel->dataset_id=$testing->dataset_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('configuration', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            "testing" => $testing
        ]);

    }


    /**
     * Finds the Testing model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Testing the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Testing::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
