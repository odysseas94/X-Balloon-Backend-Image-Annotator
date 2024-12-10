<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pure\TestingImages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="testing-images-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php try {
        echo $form->field($model, 'testing_id')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(app\models\pure\Testing::findBySql("select * from testing where status_id=1")->all(), 'id', 'prettyName'),
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
        echo $form->field($model, 'image_id')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(app\models\pure\Image::getAllRestricted(), 'id', 'prettyName'),
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true,
                "multiple" => !!$model->isNewRecord
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
