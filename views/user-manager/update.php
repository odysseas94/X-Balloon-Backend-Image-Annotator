<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pure\UserManager */

$this->title = Yii::t('app', 'Update User Manager: {name}', [
    'name' => $model->manager_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Managers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->manager_id, 'url' => ['view', 'manager_id' => $model->manager_id, 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="create-page kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
						<i class="la la-adjust"></i>
					</span>
            <h3 class="kt-portlet__head-title">
                <?= Html::encode($this->title) ?>

            </h3>

        </div>

    </div>

    <div class="kt-portlet__body">



        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
