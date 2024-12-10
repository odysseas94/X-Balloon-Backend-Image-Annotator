<?php


use kartik\editable\Editable;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataset app\models\pure\Dataset */
/* @var $searchModel app\models\search\DatasetConfigurationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'R-CNN Configuration') . " (" . Yii::t("app", "Dataset") . " : " . $dataset->name . ")";

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dataset'), 'url' => ['dataset/index']];
$this->params['breadcrumbs'][] = ['label' => $dataset->name, 'url' => ['dataset/view', 'id' => $dataset->id]];
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
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ["attribute" => "name",
                    "value" => function ($model) {
                        return "<div class='text-left'><i class='fa fa-2x fa-info-circle' data-toggle='kt-popover'  data-placement='top' data-content='$model->description'></i>  &nbsp;$model->name </div>";
                    },

                    "format" => "raw"],

                'default_value',
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'value',
                    'readonly' => function ($model, $key, $index, $widget) {
                        return false;// do not allow editing of inactive records
                    },
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    "editableOptions" => function ($model) use ($dataset) {
                        return [

                            "format" => Editable::FORMAT_BUTTON,
                            "asPopover" => false,
                            'formOptions' => ['action' => \yii\helpers\Url::to(['configuration/ajax-dataset-configuration', "dataset_id" => $dataset->id, "configuration_id" => $model->id])],


                        ];
                    }


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
            ],
        ]); ?>

        <?php Pjax::end(); ?>

    </div>
</div>