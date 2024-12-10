<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pure\Conclusion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="conclusion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'shapes')->textInput() ?>

    <?= $form->field($model, 'success_json')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date_created')->textInput() ?>

    <?= $form->field($model, 'date_updated')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
