<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pure\Conclusion */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Conclusions'), 'url' => ['index']];
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
                'shapes',
                ["attribute" => "average",
                    "value" => function ($model) {
                        return ($model->getAverage() * 100) . "%";
                    }],
                [

                    'attribute' => 'image_id',


                    'value' => function ($model) {
                        $image = \app\models\pure\Image::findBySql("select image.* from image
        inner join testing_images on testing_images.image_id=image.id and conclusion_id=$model->id")->one();
                        if ($image)
                            return Html::a($image->prettyName, "./index.php?r=image/view&id=$image->id",
                                ["target" => "_blank",
                                    "data-pjax" => "0"]);
                    },
                    "format" => "raw"],
                ["attribute" => 'success_json',
                    "value" => function ($model) {
                        return "<div class='word-break'>$model->success_json</div>";
                    },
                    "format" => "raw"
                ],
                'date_created',
                'date_updated',
            ],
        ]) ?>

    </div>

</div>
