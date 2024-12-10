<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pure\UserManager */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-manager-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($model, 'manager_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\app\models\pure\User::find()->all(), 'id' ,"fullname"),

        'pluginOptions' => [
            'allowClear' => false
        ],
    ]);
    ?>

    <?=
    $form->field($model, 'user_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\app\models\pure\User::find()->all(), 'id' ,"fullname"),

        'pluginOptions' => [
            'allowClear' => false
        ],
    ]);
    ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
