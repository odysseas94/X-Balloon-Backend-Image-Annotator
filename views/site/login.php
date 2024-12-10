<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Sign In';
$this->registerCssFile("@web/theme/custom/css/login.css", ['position' => \yii\web\View::POS_HEAD]);
?>


<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
    <div class="kt-grid kt-grid--hor kt-grid--root kt-login kt-login--v2 kt-login--signin" id="kt_login">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url(./theme/custom/img/login-background2.jpg);">
            <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                <div class="kt-login__container">
                    <div class="kt-login__logo">
                        <a href="#">
                            <img height="80" src="./theme/custom/img/logo.png">
                        </a>
                    </div>
                    <div class="kt-login__signin">
                        <div class="kt-login__head">
                            <h3 class="text-center">Sign in</h3>
                        </div>

                        <?php
                        $form = ActiveForm::begin([
                                    'options' => [
                                        'class' => 'kt-form'
                                    ]
                        ]);
                        ?>

                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>

                        <?php
//                       echo $form->field($model, 'rememberMe')->checkbox(["class"=>"kt-widget2__checkbox"])
                        ?>

                        <div class="form-group">
                            <div class='text-center justify-content-center"'>
<?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                            </div>
                        </div>

<?php ActiveForm::end(); ?>



                    </div>
                </div>





            </div>
        </div>
    </div>
</div>

