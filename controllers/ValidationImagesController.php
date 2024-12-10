<?php

namespace app\controllers;

use Yii;
use app\models\pure\ValidationImages;
use app\models\search\ValidationImagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ValidationImagesController implements the CRUD actions for ValidationImages model.
 */
class ValidationImagesController extends AuthedController
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
     * Lists all ValidationImages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ValidationImagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ValidationImages model.
     * @param integer $validation_id
     * @param integer $image_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($validation_id, $image_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($validation_id, $image_id),
        ]);
    }

    /**
     * Creates a new ValidationImages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ValidationImages();

        if ($model->load(Yii::$app->request->post())) {
            foreach ($model->image_id as $image_id) {
                $image = ValidationImages::findBySql("select * from validation_images where image_id=$image_id and validation_id=$model->validation_id")->one();
                if (!$image)
                    $image = new ValidationImages();
                $image->validation_id = $model->validation_id;
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
     * Updates an existing ValidationImages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $validation_id
     * @param integer $image_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($validation_id, $image_id)
    {
        $model = $this->findModel($validation_id, $image_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'validation_id' => $model->validation_id, 'image_id' => $model->image_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ValidationImages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $validation_id
     * @param integer $image_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($validation_id, $image_id)
    {
        $this->findModel($validation_id, $image_id)->delete();

        return $this->actionOnDelete();
    }

    /**
     * Finds the ValidationImages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $validation_id
     * @param integer $image_id
     * @return ValidationImages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($validation_id, $image_id)
    {
        if (($model = ValidationImages::findOne(['validation_id' => $validation_id, 'image_id' => $image_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
