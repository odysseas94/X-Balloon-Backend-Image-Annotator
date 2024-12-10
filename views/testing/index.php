<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use app\helpers\Override\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TestingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Testings');
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
            <?= Html::a(Yii::t('app', 'Create Testing'), ['create'], ['class' => 'btn btn-primary']) ?>
        </p>

        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                [

                    'attribute' => 'dataset_id',


                    'value' => function ($model) {

                        return Html::a(\app\models\pure\Dataset::findOne($model->dataset_id)->prettyName, "./index.php?r=dataset/view&id=$model->dataset_id",
                            ["target" => "_blank",
                                "data-pjax" => "0"]);
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => yii\helpers\ArrayHelper::map(app\models\pure\Dataset::find()->all(), 'id', 'prettyName'),
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

                    'attribute' => 'active',


                    'value' => function ($model) {
                        return Yii::t("app", $model->active);
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ['true' => Yii::t("app", "True"), 'true' => Yii::t("app", "False")],
                    'filterWidgetOptions' => [
                        'theme' => Select2::THEME_BOOTSTRAP,


                        'options' => ['prompt' => '             '],
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'format' => 'raw'
                ],
                'description:ntext',
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

                ['class' => 'yii\grid\ActionColumn',
                    'template' => "{view}&nbsp;{update}&nbsp;{configuration}&nbsp;{delete}",
                    'buttons'=>[
                        'configuration' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-wrench"></span>', \yii\helpers\Url::to(["configuration","id"=>$model->id]), [
                                'title' => Yii::t('app', 'R-CNN Configuration'),
                            ]);
                        },
                    ]],
            ],
        ]); ?>

        <?php Pjax::end(); ?>

    </div>
</div>