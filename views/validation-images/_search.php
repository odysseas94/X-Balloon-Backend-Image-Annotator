<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\ValidationImagesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="validation-images-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'validation_id') ?>

    <?= $form->field($model, 'image_id') ?>

    <?= $form->field($model, 'active') ?>

    <?= $form->field($model, 'date_created') ?>

    <?= $form->field($model, 'date_updated') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
