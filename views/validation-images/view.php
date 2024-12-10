<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pure\ValidationImages */

$this->title = $model->validation_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Validation Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="view-page kt-portlet">
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

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'validation_id' => $model->validation_id, 'image_id' => $model->image_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'validation_id' => $model->validation_id, 'image_id' => $model->image_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'validation_id',
                'image_id',
                'active',
                'date_created',
                'date_updated',
            ],
        ]) ?>

    </div>
</div>