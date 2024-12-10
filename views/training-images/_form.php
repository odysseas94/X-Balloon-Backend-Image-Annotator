<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pure\TrainingImages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="training-images-form">

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

        $appender = "";
        if (!Yii::$app->user->identity->isAdmin) {
            $image_ids_str = \app\helpers\ArrayHelper::implodeKeys(",", app\models\pure\Image::getAllRestricted(), "id");
            $appender = "image.id in ($image_ids_str) and ";
        }
        $models = \app\models\pure\Image::findBySql("select image.* from image
where $appender   not exists(select validation_id from validation_images where validation_images.image_id=image.id) ")->all();
        echo $form->field($model, 'image_id')->widget(Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map($models, 'id', 'prettyName'),
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true,
                "multiple" => !$model->image_id
            ],
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } ?>

    <?= $form->field($model, 'active')->dropDownList([
        'true' => Yii::t("app", 'True'),
        'false' => Yii::t("app", 'False'),]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
