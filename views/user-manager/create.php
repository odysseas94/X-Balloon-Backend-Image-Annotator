<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pure\UserManager */

$this->title = Yii::t('app', 'Create User Manager');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Managers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-page kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
						<i class="la la-adjust"></i>
					</span>
            <h3 class="kt-portlet__head-title">
                <?= Html::encode($this->title) ?>

            </h3>

        </div>

    </div>

    <div class="kt-portlet__body">



        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>