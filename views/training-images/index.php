<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use app\helpers\Override\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TrainingImagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Training Images');
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

        <p>
            <?= Html::a(Yii::t('app', 'Create Training Images'), ['create'], ['class' => 'btn btn-primary']) ?>
        </p>

        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [

                    'attribute' => 'training_id',


                    "value" => function ($model) {
                        return Html::a($model->training->prettyName, "./index.php?r=training/view&id=$model->training_id", [
                            "target" => "_blank",
                            "data-pjax" => "0"
                        ]);
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => yii\helpers\ArrayHelper::map(app\models\pure\Training::find()->all(), 'id', 'prettyName'),
                    'filterWidgetOptions' => [
                        'theme' => Select2::THEME_BOOTSTRAP,


                        'options' => ['prompt' => '             '],
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'format' => 'raw'
                ],
                [

                    'attribute' => 'image_id',


                    'value' => function ($model) {
                        return Html::a($model->image->prettyName, "./index.php?r=image/index&ImageSearch[id]=$model->image_id", ["target" => "_blank",
                            "data-pjax" => "0"
                        ]);
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => yii\helpers\ArrayHelper::map(app\models\pure\Image::getAllRestricted(), 'id', 'prettyName'),
                    'filterWidgetOptions' => [
                        'theme' => Select2::THEME_BOOTSTRAP,


                        'options' => ['prompt' => '             '],
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'format' => 'raw'
                ],

                [

                    'attribute' => 'active',


                    'value' => function ($model) {
                        return $model->active ? Yii::t("app", "True") : Yii::t("app", "False");
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ["true" => Yii::t("app", "True"), "false" => Yii::t("app", "False")],
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
                ["attribute" => "date_updated",

                    'filterType' => GridView::FILTER_DATE,
                    'filterWidgetOptions' => [
                        'readonly' => true,

                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose' => true
                        ]],
                ],


                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

        <?php Pjax::end(); ?>

    </div>
</div>