<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pure\Shape */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shapes'), 'url' => ['index']];
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

                ["attribute" => "shape_type_id",
                    "value" => function ($model) {
                        return $model->shapeType->pretty_name;
                    }],
                ["attribute" => "class_id",
                    "value" => function ($model) {
                        return $model->class->pretty_name;
                    }],

                ["attribute" => "image_id",
                    "value" => function ($model) {

                        $image = $model->image;
                        return Html::a($image->prettyName, "./index.php?r=image/view&id=$image->id", ["target" => "_blank"]);
                    },
                    'format' => 'raw'],
                ["attribute" => "shape_creator",
                    "value" => function ($model) {
                        $user = \app\models\pure\User::findBySql("select user.* from user
  inner join shape_creator on shape_creator.user_id=user.id and shape_id=$model->id")->one();
                        return Html::a($user->fullname, "./index.php?r=user/view&id=$user->id", ["target" => "_blank"]);
                    },
                    'format' => 'raw'],
                'points:ntext',
                'area',
                'date_created',
                'date_updated',
            ],
        ]) ?>

    </div>

</div>
