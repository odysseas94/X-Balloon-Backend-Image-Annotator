<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pure\User */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="view-page kt-portlet">
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

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

            <?php if (Yii::$app->user->identity->isAdmin) {

                ?>
                <?=
                Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ])
                ?>
                <?php

            }

            ?>
        </p>

        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                ["attribute" => "image",
                    'value' => function ($model) {

                        if ($model->image)
                            return yii\helpers\Html::img($model->image->fullImagePath, ["width" => "40px"]);
                        else
                            return null;
                    }, 'format' => "raw",
                    "filter" => false,
                ],
                'username',
                'email:email',
                'firstname',
                'lastname',

                ["attribute" => "gender_id",
                    "value" => function ($model) {
                        return $model->gender->pretty_name;
                    }],
                ["attribute" => "user_type_id",
                    "value" => function ($model) {
                        return $model->userType->pretty_name;
                    }],
                ["attribute" => "country_id",
                    "value" => function ($model) {
                        return $model->country->name;
                    }],

                'status',
                'date_created',
                'date_updated',
            ],
        ])
        ?>

    </div>
</div>
