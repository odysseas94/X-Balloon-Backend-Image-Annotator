<?php

namespace app\controllers;

use Yii;
use app\models\pure\UserManager;
use app\models\search\UserManagerSearch;
use app\controllers\CController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserManagerController implements the CRUD actions for UserManager model.
 */
class UserManagerController extends AuthedController
{
    /**
     * {@inheritdoc}
     */

    public $enableCsrfValidation=false;
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
     * Lists all UserManager models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserManagerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single UserManager model.
     * @param integer $manager_id
     * @param integer $user_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */


    public function actionView($manager_id, $user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($manager_id, $user_id),
        ]);
    }

    /**
     * Creates a new UserManager model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


    public function actionCreate()
    {
        $model = new UserManager();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'manager_id' => $model->manager_id, 'user_id' => $model->user_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing UserManager model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $manager_id
     * @param integer $user_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */


    public function actionUpdate($manager_id, $user_id)
    {
        $model = $this->findModel($manager_id, $user_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'manager_id' => $model->manager_id, 'user_id' => $model->user_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserManager model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $manager_id
     * @param integer $user_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($manager_id, $user_id)
    {
        $this->findModel($manager_id, $user_id)->delete();

        return $this->actionOnDelete();
    }


    /**
     * Finds the UserManager model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $manager_id
     * @param integer $user_id
     * @return UserManager the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */


    protected function findModel($manager_id, $user_id)
    {
        if (($model = UserManager::findOne(['manager_id' => $manager_id, 'user_id' => $user_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
