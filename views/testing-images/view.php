<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pure\TestingImages */

$this->title = $model->testing_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Testing Images'), 'url' => ['index']];
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
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'testing_id' => $model->testing_id, 'image_id' => $model->image_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'testing_id' => $model->testing_id, 'image_id' => $model->image_id], [
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
                ["attribute" => 'testing_id',
                    "value" => function ($model) {
                        return $model->testing->prettyName;
                    }],
                [

                    'attribute' => 'image_id',


                    'value' => function ($model) {

                        return Html::a(\app\models\pure\Image::findOne($model->image_id)->prettyName, "./index.php?r=image/view&id=$model->image_id",
                            ["target" => "_blank",
                                "data-pjax" => "0"]);
                    },
                    "format" => "raw"],

                ["attribute" => "statistics",
                    "value" => function ($model) {
                        $imageStats = new \app\helpers\ImageStats($model->image, $model->testing_id);
                        $shapes = $imageStats->init();
                        $shapes_str = "";
                        foreach ($shapes as $shape) {
                            $shapes_str .= $shape->class->prettyName . " : " . $shape->temp_value . "%<br/>";
                        }

                        return $shapes_str;
                    },
                    "format" => "raw",
                    "label" => Yii::t("app", "Statistics"),


                ],
                ["attribute" => 'status_id',
                    "value" => function ($model) {
                        return $model->status->prettyName;
                    }],
                [

                    'attribute' => 'conclusion_id',


                    'value' => function ($model) {

                        if ($model->conclusion_id)
                            return Html::a(\app\models\pure\Conclusion::findOne($model->conclusion_id)->prettyName, "./index.php?r=conclusion/view&id=$model->conclusion_id",
                                ["target" => "_blank",
                                    "data-pjax" => "0"]);
                        else
                            return null;
                    },
                    "format" => "raw"],
                'date_created',
                'date_updated',
            ],
        ]) ?>

    </div>
</div>