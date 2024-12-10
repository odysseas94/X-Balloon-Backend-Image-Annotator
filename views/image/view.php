<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pure\Image[] */
$title = "";
foreach ($model as $m) {
    $title .= $m->name;
}
$this->title = $title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Images'), 'url' => ['index']];
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


        <div class="row">


            <?php
            $size = count($model);
            $col = "col-4";

            if ($size == 1)
                $col = "col-12";
            else if ($size == 2) {
                $col = "col-6";
            }
            foreach ($model as $m) {
                echo "<div class='$col'>";


                ?>
                <p>
                    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $m->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?').' '. Yii::t("app","Image").' ('.$m->name.')',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $m,
                    'attributes' => [
                        'id',
                        ["attribute" => "thumbnail_path",
                            "value" => function ($model) {
                                return Html::img($model->fullThumbnailPath,
                                    ['height' => '50px']);
                            },
                            "filter" => false,

                            "format" => "raw"],
                        'name',
                        ["attribute" => "path",
                            "value" => function ($model) {
                                return Html::a(basename($model->path), $model->fullImagePath,
                                    ["target" => "_blank"]);
                            },
                            "filter" => false,

                            "format" => "raw"],

                        ["attribute" => "statistics",
                            "value" => function ($model) {
                                $imageStats = new \app\helpers\ImageStats($model, null);
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
                        [

                            'attribute' => 'image_creator',


                            'value' => function ($model) {
                                $image_creator = \app\models\pure\User::findBySql("select user.* from user 
  inner join image_creator on user.id=user_id and image_creator.image_id=$model->id")->one();
                                return Html::a($image_creator->fullname, "./index.php?r=user/view&id=$image_creator->id", ["target" => "_blank",
                                    "data-pjax" => "0"]);
                            },
                            "format" => "raw"
                        ],
                        [

                            'attribute' => 'visible',

                            'value' => function ($model) {
                                return $model->visible ? Yii::t("app", "True") : Yii::t("app", "False");
                            },

                        ],
                        ["attribute" => "size",
                            "value" => function ($model) {
                                return $model->getSizeMB();
                            }],
                        ["attribute" => "width",
                            "value" => function ($model) {
                                return $model->width . " px";

                            }],
                        ["attribute" => "height",
                            "value" => function ($model) {
                                return $model->height . " px";

                            }],
                        'date_created',
                        'date_updated',
                    ],
                ]) ?>


                <?php
                echo "<div>";
            } ?>
        </div>
    </div>
</div>
