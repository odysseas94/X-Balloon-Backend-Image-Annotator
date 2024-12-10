<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use app\models\pure\Country;
use app\models\pure\UserType;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\pure\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>


    <?php

    echo $form->field($model, 'date_born')->widget(DatePicker::className(), [
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'options' => ['placeholder' => ' '],
        'removeButton' => false,
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ])
    ?>


    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>


    <?=
    $form->field($model, 'country_id')
        ->dropDownList(
            ArrayHelper::map(Country::findBySql("select * from country where active=1")->all(), 'id', 'name')
        )
    ?>


    <?=
    $form->field($model, 'gender_id')->dropDownList(
        ArrayHelper::map(\app\models\pure\Gender::find()->all(), 'id', 'pretty_name')
    )
    ?>

    <?=

    $form->field($model, 'user_type_id')->dropDownList(
        ArrayHelper::map(UserType::getAllRestrictedCurrent(), 'id', 'pretty_name')
    );
    ?>

    <?=


    $form->field($model->imageInstance(), 'image')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        "language" => Yii::$app->language,
        'pluginOptions' => [
            'initialPreview' => [
                $model->image_id ? Html::img($model->image->getFullImagePath()) : null
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


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
