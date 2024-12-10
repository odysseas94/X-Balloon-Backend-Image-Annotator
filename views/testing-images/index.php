<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use app\helpers\Override\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TestingImagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Testing Images');
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
            <?= Html::a(Yii::t('app', 'Create Testing Images'), ['create'], ['class' => 'btn btn-primary']) ?>
        </p>

        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [

                    'attribute' => 'testing_id',


                    'value' => function ($model) {

                        return Html::a(\app\models\pure\Testing::findOne($model->testing_id)->prettyName, "./index.php?r=testing/view&id=$model->testing_id",
                            ["target" => "_blank",
                                "data-pjax" => "0"]);
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => yii\helpers\ArrayHelper::map(app\models\pure\Testing::find()->all(), 'id', 'prettyName'),
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

                        return Html::a(\app\models\pure\Image::findOne($model->image_id)->prettyName, "./index.php?r=image/view&id=$model->image_id",
                            ["target" => "_blank",
                                "data-pjax" => "0"]);
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

                    'attribute' => 'status_id',


                    "value" => function ($model) {
                        return $model->status->prettyName;
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => yii\helpers\ArrayHelper::map(app\models\pure\AIStatus::find()->all(), 'id', 'prettyName'),
                    'filterWidgetOptions' => [
                        'theme' => Select2::THEME_BOOTSTRAP,


                        'options' => ['prompt' => '             '],
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'format' => 'raw'
                ],
                [

                    'attribute' => 'conclusion_id',


                    'value' => function ($model) {
                        if ($model->conclusion_id)
                            return Html::a(\app\models\pure\Conclusion::findOne($model->conclusion_id)->prettyName, "./index.php?r=conclusion/view&id=$model->conclusion_id",
                                ["target" => "_blank",
                                    "data-pjax" => "0"]);
                        return null;
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => yii\helpers\ArrayHelper::map(app\models\pure\Conclusion::find()->all(), 'id', 'prettyName'),
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
                //'date_updated',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

        <?php Pjax::end(); ?>

    </div>
</div>