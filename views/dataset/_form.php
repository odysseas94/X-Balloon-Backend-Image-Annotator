<?php

use app\helpers\Override\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\pure\Dataset */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dataset-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php try {
        echo $form->field($model, 'training_id')->select2(
            \yii\helpers\ArrayHelper::map(app\models\pure\Training::find()->all(), 'id', 'prettyName')
        );
    } catch (Exception $e) {
        echo $e->getMessage();
    } ?>

    <?php try {
        echo $form->field($model, 'validation_id')->select2(yii\helpers\ArrayHelper::map(app\models\pure\Validation::find()->all(), 'id', 'prettyName'),
        );
    } catch (Exception $e) {
        echo $e->getMessage();
    } ?>

    <?php try {
        echo $form->field($model, 'status_id')->select2(\yii\helpers\ArrayHelper::map(app\models\pure\AIStatus::find()->where(["name" => "pending"])->all(), 'id', 'prettyName'));
    } catch (Exception $e) {
        echo $e->getMessage();
    } ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
