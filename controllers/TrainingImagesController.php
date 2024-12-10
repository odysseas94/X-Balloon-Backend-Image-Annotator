<?php

namespace app\controllers;

use app\models\pure\Image;
use app\models\pure\Training;
use Yii;
use app\models\pure\TrainingImages;
use app\models\search\TrainingImagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TrainingImagesController implements the CRUD actions for TrainingImages model.
 */
class TrainingImagesController extends AuthedController
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
     * Lists all TrainingImages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TrainingImagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TrainingImages model.
     * @param integer $training_id
     * @param integer $image_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($training_id, $image_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($training_id, $image_id),
        ]);
    }

    /**
     * Creates a new TrainingImages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TrainingImages();

        if ($model->load(Yii::$app->request->post())) {
            foreach ($model->image_id as $image_id) {
                $image = TrainingImages::findBySql("select * from training_images where image_id=$image_id and training_id=$model->training_id")->one();
                if (!$image)
                    $image = new TrainingImages();
                $image->training_id = $model->training_id;
                $image->image_id =$image_id;
                $image->active = $model->active;
                $image->save();

            }
            Yii::$app->session->setFlash("success", Yii::t("app","Set Success"));
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TrainingImages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $training_id
     * @param integer $image_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($training_id, $image_id)
    {
        $model = $this->findModel($training_id, $image_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'training_id' => $model->training_id, 'image_id' => $model->image_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TrainingImages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $training_id
     * @param integer $image_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($training_id, $image_id)
    {
        $this->findModel($training_id, $image_id)->delete();

        return $this->actionOnDelete();
    }

    /**
     * Finds the TrainingImages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $training_id
     * @param integer $image_id
     * @return TrainingImages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($training_id, $image_id)
    {
        if (($model = TrainingImages::findOne(['training_id' => $training_id, 'image_id' => $image_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
