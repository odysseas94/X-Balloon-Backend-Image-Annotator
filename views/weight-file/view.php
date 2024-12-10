<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pure\WeightFile */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Weight Files'), 'url' => ['index']];
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
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
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
                'id',
                'name',
                'path',

                'success_ratio',
                'error_ratio',
                ["attribute" => "configuration",
                    "value" => function ($model) {
                        return "<div class='break-to-lines'>" . $model->configuration . "</div>";
                    },
                    "format" => "raw"],
                'val_loss',
                'val_rpn_class_loss',
                'val_rpn_bbox_loss',
                'val_mrcnn_class_loss',
                'val_mrcnn_bbox_loss',
                'val_mrcnn_mask_loss',
                'rpn_class_loss',
                'rpn_bbox_loss',
                'mrcnn_class_loss',
                'mrcnn_bbox_loss',
                'mrcnn_mask_loss',

                'date_created',
                'date_updated',
            ],
        ]) ?>

    </div>
</div>