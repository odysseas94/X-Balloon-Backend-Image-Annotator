<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pure\WeightFile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="weight-file-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'success_ratio')->textInput() ?>

    <?= $form->field($model, 'error_ratio')->textInput() ?>

    <?= $form->field($model, 'val_loss')->textInput() ?>

    <?= $form->field($model, 'val_rpn_class_loss')->textInput() ?>

    <?= $form->field($model, 'val_rpn_bbox_loss')->textInput() ?>

    <?= $form->field($model, 'val_mrcnn_class_loss')->textInput() ?>

    <?= $form->field($model, 'val_mrcnn_bbox_loss')->textInput() ?>

    <?= $form->field($model, 'val_mrcnn_mask_loss')->textInput() ?>

    <?= $form->field($model, 'rpn_class_loss')->textInput() ?>

    <?= $form->field($model, 'rpn_bbox_loss')->textInput() ?>

    <?= $form->field($model, 'mrcnn_class_loss')->textInput() ?>

    <?= $form->field($model, 'mrcnn_bbox_loss')->textInput() ?>

    <?= $form->field($model, 'mrcnn_mask_loss')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
