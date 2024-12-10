<?php

use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use app\helpers\Override\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pure\Image */
/* @var $form yii\widgets\ActiveForm */
/* @var \app\models\pure\ImageCreator $image_creator */

?>

<div class="image-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <?php try {

        echo $form->field($image_creator, 'user_id')->select2(
            \yii\helpers\ArrayHelper::map(app\models\pure\User::getAllRestricted(), 'id', 'fullname'),
            ['options' => ['placeholder' => ''],
                'pluginOptions' => [
                    'allowClear' => true,
                    "multiple" => false
                ]
            ]

        );
    } catch (Exception $e) {
        echo $e->getMessage();
    } ?>

    <?=


    $form->field($model, $model->isNewRecord ? "images" : "image")->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*',
            "multiple" => $model->isNewRecord],
        'pluginOptions' => [
            'initialPreview' => [
                $model->path ? Html::img($model->path) : null,
            ],
            'showCaption' => false,
            'showCancel' => false,
            'showRemove' => false,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'browseLabel' => Yii::t('app', "Image Upload"),

        ]
    ])
    ?>


    <?= $form->field($model, 'visible')->dropDownList([1 => Yii::t("app", 'True'), 0 => Yii::t("app", 'False'),]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
