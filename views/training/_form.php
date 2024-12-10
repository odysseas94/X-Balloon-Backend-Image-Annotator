<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pure\Training */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="training-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logs')->textarea(['rows' => 6]) ?>

    <?php try {
        echo $form->field($model, 'status_id')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(app\models\pure\AIStatus::find()->all(), 'id', 'prettyName'),
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true,
                "multiple" => false
            ],
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } ?>

    <?php
    $trainingClassification = new \app\models\pure\TrainingClassification();
    if (!$model->isNewRecord) {
        $trainingClassification->classification_id = \app\helpers\ArrayHelper::keys($model->trainingClassifications, "classification_id");
    }
    try {
        echo $form->field($trainingClassification, 'classification_id')->widget(Select2::classname(), [
                "name" => "TrainingClassification[classification_id]",

                'data' => \yii\helpers\ArrayHelper::map(app\models\pure\Classification::find()->all(), 'id', 'pretty_name'),
                'options' => ['placeholder' => '', 'required' => "true"],
                'pluginOptions' => [
                    'allowClear' => true,
                    "multiple" => true
                ],
            ]) . "<br/>";
    } catch (Exception $e) {
        echo $e->getMessage();
    } ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
