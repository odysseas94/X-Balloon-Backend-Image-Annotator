<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\WeightFileSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weight-file-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'success_ratio') ?>

    <?= $form->field($model, 'error_ratio') ?>

    <?= $form->field($model, 'val_loss') ?>

    <?php // echo $form->field($model, 'val_rpn_class_loss') ?>

    <?php // echo $form->field($model, 'val_rpn_bbox_loss') ?>

    <?php // echo $form->field($model, 'val_mrcnn_class_loss') ?>

    <?php // echo $form->field($model, 'val_mrcnn_bbox_loss') ?>

    <?php // echo $form->field($model, 'val_mrcnn_mask_loss') ?>

    <?php // echo $form->field($model, 'rpn_class_loss') ?>

    <?php // echo $form->field($model, 'rpn_bbox_loss') ?>

    <?php // echo $form->field($model, 'mrcnn_class_loss') ?>

    <?php // echo $form->field($model, 'mrcnn_bbox_loss') ?>

    <?php // echo $form->field($model, 'mrcnn_mask_loss') ?>

    <?php // echo $form->field($model, 'path') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'date_updated') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
