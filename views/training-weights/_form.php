<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pure\TrainingWeights */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="training-weights-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php try {
        echo $form->field($model, 'training_id')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(app\models\pure\Training::find()->all(), 'id', 'prettyName'),
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true,
                "multiple" => false
            ],
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } ?>

    <?php try {
        echo $form->field($model, 'weight_child_id')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(app\models\pure\WeightFile::find()->all(), 'id', 'prettyName'),
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true,
                "multiple" => false
            ],
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } ?>

    <?php try {
        echo $form->field($model, 'weight_parent_id')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(app\models\pure\WeightFile::find()->all(), 'id', 'prettyName'),
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true,
                "multiple" => false
            ],
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
