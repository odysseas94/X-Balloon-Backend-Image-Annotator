<?php

namespace app\controllers;

use app\models\pure\AIStatus;
use app\models\pure\Image;
use Yii;
use app\models\pure\TestingImages;
use app\models\search\TestingImagesSearch;
use app\controllers\CController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestingImagesController implements the CRUD actions for TestingImages model.
 */
class TestingImagesController extends AuthedController
{
    /**
     * {@inheritdoc}
     */
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
     * Lists all TestingImages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestingImagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TestingImages model.
     * @param integer $testing_id
     * @param integer $image_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($testing_id, $image_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($testing_id, $image_id),
        ]);
    }

    /**
     * Creates a new TestingImages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TestingImages();

        if ($model->load(Yii::$app->request->post())) {
            foreach ($model->image_id as $image_id) {
                $image = TestingImages::findBySql("select * from testing_images where image_id=$image_id and testing_id=$model->testing_id")->one();
                if (!$image)
                    $image = new TestingImages();
                else
                    continue;
                $image->testing_id = $model->testing_id;
                $image->image_id = $image_id;
                $image->status_id = AIStatus::findOne(["name" => "pending"])->id;
                $image->save();

            }
            Yii::$app->session->setFlash("success", Yii::t("app", "Set Success"));
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TestingImages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $testing_id
     * @param integer $image_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($testing_id, $image_id)
    {
        $model = $this->findModel($testing_id, $image_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'testing_id' => $model->testing_id, 'image_id' => $model->image_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TestingImages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $testing_id
     * @param integer $image_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($testing_id, $image_id)
    {
        $model = $this->findModel($testing_id, $image_id);


        Yii::$app->db->createCommand("
                 delete shape.* from shape
                inner join image_shape on image_shape.shape_id=shape.id and testing_id=$model->testing_id and image_id=$model->image_id")->execute();
        $model->delete();
        return $this->actionOnDelete();
    }

    /**
     * Finds the TestingImages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $testing_id
     * @param integer $image_id
     * @return TestingImages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($testing_id, $image_id)
    {
        if (($model = TestingImages::findOne(['testing_id' => $testing_id, 'image_id' => $image_id])) !== null) {

            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
