<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pure\TestingImages */

$this->title = Yii::t('app', 'Update Testing Images: {name}', [
    'name' => $model->testing_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Testing Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->testing_id, 'url' => ['view', 'testing_id' => $model->testing_id, 'image_id' => $model->image_id]];
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
