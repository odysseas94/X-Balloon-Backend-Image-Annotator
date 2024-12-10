<?php

namespace app\controllers;

use app\models\pure\TrainingClassification;
use Yii;
use app\models\pure\Training;
use app\models\search\TrainingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TrainingController implements the CRUD actions for Training model.
 */
class TrainingController extends AuthedController
{
    /**
     * {@inheritdoc}
     */

    protected $for_manager = true;

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
     * Lists all Training models.
     * @return mixed
     */


    public function actionIndex()
    {
        $searchModel = new TrainingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Training model.
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
     * Creates a new Training model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Training();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $post = Yii::$app->request->post();


            if (isset($post["TrainingClassification"]) && isset($post["TrainingClassification"]["classification_id"]) && $classifications_ids = $post["TrainingClassification"]["classification_id"]) {
                foreach ($classifications_ids as $classifications_id) {
                    $trainingClassification = new TrainingClassification();
                    $trainingClassification->training_id = $model->id;
                    $trainingClassification->classification_id = $classifications_id;
                    $trainingClassification->save(false);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Training model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $post = Yii::$app->request->post();
            Yii::$app->db->createCommand("
                 delete  from training_classification where training_id=$model->id
                 ")->execute();

            if (isset($post["TrainingClassification"]) && isset($post["TrainingClassification"]["classification_id"]) && $classifications_ids = $post["TrainingClassification"]["classification_id"]) {
                foreach ($classifications_ids as $classifications_id) {
                    $trainingClassification = new TrainingClassification();
                    $trainingClassification->training_id = $model->id;
                    $trainingClassification->classification_id = $classifications_id;
                    $trainingClassification->save(false);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Training model.
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
     * Finds the Training model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Training the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Training::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
