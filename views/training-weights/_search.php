<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\TrainingWeightsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="training-weights-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'training_id') ?>

    <?= $form->field($model, 'weight_child_id') ?>

    <?= $form->field($model, 'weight_parent_id') ?>

    <?= $form->field($model, 'date_created') ?>

    <?= $form->field($model, 'date_updated') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
