<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pure\Shape */

$this->title = Yii::t('app', 'Update Shape: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shapes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
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
            "shape_creator"=>$shape_creator,
            "image_shape"=>$image_shape
        ]) ?>

    </div>

</div>


