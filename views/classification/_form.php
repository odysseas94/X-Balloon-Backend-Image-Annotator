<?php

use kartik\color\ColorInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pure\Classification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="classification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pretty_name')->textInput(['maxlength' => true]) ?>

    <?php try {
        echo $form->field($model, 'color')->widget(ColorInput::classname(), [
            'options' => ['placeholder' => 'Select color ...'],
        ]);
    } catch (Exception $e) {
    } ?>


    <?= $form->field($model, 'visible')->dropDownList([
        'true' => Yii::t("app", 'True'),
        'false' => Yii::t("app", 'False'),]) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
