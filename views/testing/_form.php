<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pure\Testing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="testing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?php try {
        echo $form->field($model, 'dataset_id')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(app\models\pure\Dataset::find()->all(), 'id', 'prettyName'),
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
        echo $form->field($model, 'status_id')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(app\models\pure\AIStatus::findBySql("select * from ai_status where name like 'pending'")->all(), 'id', 'prettyName'),
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true,
                "multiple" => false
            ],
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } ?>

    <?= $form->field($model, 'active')->dropDownList(['true' => Yii::t("app", 'True'), "false" => Yii::t("app", 'False'),]) ?>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
