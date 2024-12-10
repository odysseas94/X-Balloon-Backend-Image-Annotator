<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pure\Shape */
/* @var $shape_creator app\models\pure\ShapeCreator */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shape-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'points')->textarea(['rows' => 6,'readOnly'=>true]) ?>

    <?php try {

        echo $form->field($shape_creator, 'user_id')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(app\models\pure\User::find()->all(), 'id', 'fullname'),
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

        echo $form->field($model, 'shape_type_id')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(app\models\pure\ShapeType::find()->all(), 'id', 'pretty_name'),
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

        echo $form->field($model, 'class_id')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(app\models\pure\Classification::find()->all(), 'id', 'pretty_name'),
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true,
                "multiple" => false
            ],
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } ?>
    <?= $form->field($image_shape, 'deleted')->dropDownList([1 => Yii::t("app", 'True'), 0 => Yii::t("app", 'False'),], ['prompt' => '']) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
