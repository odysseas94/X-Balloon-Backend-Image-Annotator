<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pure\Classification */

$this->title = $model->pretty_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Classifications'), 'url' => ['index']];
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
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'pretty_name',
                ["attribute" => "color",
                    "value" => function ($model) {
                        return "<span class=\"badge\" style=\"background-color: $model->color\"> </span>  <color>$model->color</color></td>";
                    },
                    "format" => "raw",
                ],

                ["attribute" => "visible"
                    , "value" => function ($model) {
                    return Yii::t("app", $model->visible);
                }],
                'date_created',
                'date_updated',
            ],
        ]) ?>

    </div>

</div>
