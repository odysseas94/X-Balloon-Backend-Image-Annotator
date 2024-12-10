<?php

use app\helpers\Override\GridView;
use app\models\pure\Image;

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Images');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="index-page kt-portlet">
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

        <div class="">
            <p>
                <?= Html::a(Yii::t('app', 'Add'), ['create'], ['class' => 'btn btn-primary']) ?>
            </p>
        </div>

        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,

            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                ["attribute" => "thumbnail_path",
                    "value" => function ($model) {
                        return Html::img($model->fullThumbnailPath,
                            ['height' => '50px']);
                    },
                    "filter" => false,
                    "label" => " ",

                    "format" => "raw"],
                'id',


                [

                    'attribute' => 'image_creator',


                    'value' => function ($model) {
                        return Html::a(\app\models\pure\User::findOne($model->image_creator)->fullname, "./index.php?r=user/view&id=$model->image_creator", ["target" => "_blank",
                            "data-pjax" => "0"]);
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => yii\helpers\ArrayHelper::map(app\models\pure\User::getAllRestricted(), 'id', 'fullname'),
                    'filterWidgetOptions' => [
                        'theme' => Select2::THEME_BOOTSTRAP,


                        'options' => ['prompt' => '             '],
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'format' => 'raw'
                ],
                'name',

//            ["attribute" => "path",
//                "value" => function ($model) {
//                    return Html::a(basename($model->path), $model->path,
//                        ["target" => "_blank",
//                            "data-pjax" => "0"]
//
//                    );
//                },
////                "filter" => false,
//
//                "format" => "raw"],
                ["attribute" => "size",
                    "value" => function ($model) {
                        return Image::formatBytes($model->size);
                    },
                    "filter" => false,],
                ["attribute" => "shapes_all_count",
                    "value" => function ($model) {
                        return Html::a($model->shapes_all_count, "./index.php?r=shape/index&ShapeSearch[image_id]=$model->id", [
                            "target" => "_blank",
                            "data-pjax" => "0"
                        ]);
                    },
                    "format" => "raw",
                    "filter" => false,
                ],

                [

                    'attribute' => 'visible',


                    'value' => function ($model) {
                        return $model->visible ? Yii::t("app", "True") : Yii::t("app", "False");
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => [1 => Yii::t("app", "True"), 0 => Yii::t("app", "False")],
                    'filterWidgetOptions' => [
                        'theme' => Select2::THEME_BOOTSTRAP,


                        'options' => ['prompt' => '             '],
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'format' => 'raw'
                ],
                ["attribute" => "date_created",

                    'filterType' => GridView::FILTER_DATE,
                    'filterWidgetOptions' => [
                        'readonly' => true,

                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose' => true
                        ]],
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {delete}',],
                //'date_created',
                //'date_updated',


            ],
            'panel' => [

                'type' => 'default',

            ],
            'condensed' => true,
            'export' => [
                'fontAwesome' => true
            ],
            'toolbar' => [
                [
                    'content' => "",

                    'options' => ['class' => 'btn-group-sm']
                ],
                '{toggleData}'
            ],
        ]); ?>

        <?php Pjax::end(); ?>

    </div>

</div>
