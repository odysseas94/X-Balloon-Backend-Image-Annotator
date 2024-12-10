<?php

namespace app\controllers;

use app\models\pure\ImageShape;
use app\models\pure\ShapeCreator;
use Yii;
use app\models\pure\Shape;
use app\models\search\ShapeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ShapeController implements the CRUD actions for Shape model.
 */
class ShapeController extends AuthedController
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
     * Lists all Shape models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShapeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single Shape model.
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
     * Creates a new Shape model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new Shape();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            Yii::$app->session->setFlash("success","working");
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Updates an existing Shape model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $shape_creator = ShapeCreator::findBySql("select * from shape_creator where shape_id=$model->id")->one();
        $image_shape = ImageShape::findBySql("select * from image_shape where shape_id=$model->id")->one();

        if ($model->load(Yii::$app->request->post()) && $shape_creator->load(Yii::$app->request->post()) && $image_shape->load(Yii::$app->request->post())
            && $model->save() && $shape_creator->save() && $image_shape->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            "shape_creator" => $shape_creator,
            "image_shape" => $image_shape
        ]);
    }

    /**
     * Deletes an existing Shape model.
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

    /**
     * Finds the Shape model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return array|\yii\db\ActiveRecord
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\web\ForbiddenHttpException
     */
    protected function findModel($id)
    {

        if ($id)
            if ($this->user->isAdmin && (($model = Shape::findOne($id)) !== null)) {
                return $model;
            } else if (($model = Shape::getRestricted($this->user->id, $id)) === null)
                $this->forbid();
            else if ($model !== null)
                return $model;


        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
