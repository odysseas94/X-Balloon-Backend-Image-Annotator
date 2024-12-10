<?php

/* @var $this yii\web\View */
/* @var $shapesCount  \yii\helpers\Json */

/* @var $shapesContByDate \yii\helpers\Json */
/* @var $allConclusionsByDate \yii\helpers\Json */

/* @var $shapesCountAutomated \yii\helpers\Json */

use yii\web\View;

$this->title = 'Dashboard';
$this->registerJs(
    "window.models={shapesCount:$shapesCount,shapesContByDate:$shapesContByDate,shapesCountAutomated:$shapesCountAutomated,allConclusionsByDate:$allConclusionsByDate};
    window.translations={counter:'" . Yii::t("app", "Images") . "',percentage:'" . Yii::t("app", "Percentage Accuracy") . "',total_shapes:'" . Yii::t("app", "Total Findings") . "'};",
    View::POS_HEAD);

$this->registerJsFile("@web/theme/custom/js/DashboardAdmin.js",
    ['depends' => [yii\web\JqueryAsset::className()]]
);
$total_manual_shapes = 0;
$total_generated_shapes = 0;
$shapesCount = \yii\helpers\Json::decode($shapesCount);
$shapesCountAutomated = \yii\helpers\Json::decode($shapesCountAutomated);
foreach ($shapesCount as $shape)
    $total_manual_shapes += $shape["count"];
foreach ($shapesCountAutomated as $shape)
    $total_generated_shapes += $shape["count"];

?>
<div class="site-index">

    <div class="row">
        <div class="col-xl-4">
            <!--begin:: Widgets/Daily Sales-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-widget14">
                    <div class="kt-widget14__header kt-margin-b-30">
                        <h3 class="kt-widget14__title">
                            <?= Yii::t("app", "Daily saved Findings") ?>
                        </h3>
                        <span class="kt-widget14__desc">
				    <?= (Yii::t("app", "Last") . " 16 " . Yii::t("app", "days")) ?>
			</span>
                    </div>
                    <div class="kt-widget14__chart" style="height:120px;">
                        <canvas id="kt_chart_daily_saved_findings"></canvas>
                    </div>
                </div>
            </div>
            <!--end:: Widgets/Daily Sales-->            </div>
        <div class="col-xl-4">
            <!--begin:: Widgets/Profit Share-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-widget14">
                    <div class="kt-widget14__header">
                        <h3 class="kt-widget14__title">
                            <?= Yii::t("app", "Total manual saved Findings") ?>
                        </h3>
                        <span class="kt-widget14__desc">
				      <?= Yii::t("app", "All User generated") ?>
			</span>
                    </div>
                    <div class="kt-widget14__content">
                        <div class="kt-widget14__chart">
                            <div class="kt-widget14__stat"><?= $total_manual_shapes ?></div>
                            <canvas id="kt_chart_total_saved_findings" style="height: 150px; width: 150px;"></canvas>
                        </div>
                        <div class="kt-widget14__legends">
                            <?php $index = 0;
                            foreach ($shapesCount as $shape) {
                                if ($index++ > 4) break;

                                echo "        <div class=\"kt-widget14__legend\">
                                <span style='background-color:{$shape["color"]}!important;' class=\"kt-widget14__bullet\"></span>
                                <span class=\"kt-widget14__stats\">" . ($shape["count"] ? round((($shape["count"] / $total_manual_shapes) * 100), 1) : 0) . "% {$shape["pretty_name"]}</span>
                            </div>";


                            } ?>
                        </div>

                    </div>
                </div>
            </div>
            <!--end:: Widgets/Profit Share-->            </div>
        <div class="col-xl-4">
            <!--begin:: Widgets/Revenue Change-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-widget14">
                    <div class="kt-widget14__header">
                        <h3 class="kt-widget14__title">
                            <?= Yii::t("app", "Total Generated Findings") ?>
                        </h3>
                        <span class="kt-widget14__desc">
	    <?= Yii::t("app", "All AI Generated") ?>
			</span>
                    </div>
                    <div class="kt-widget14__content">
                        <div class="kt-widget14__chart">
                            <div id="kt_chart_generated_findings" style="height: 150px; width: 150px;"></div>
                        </div>
                        <div class="kt-widget14__legends">
                            <div class="kt-widget14__legends">
                                <?php $index = 0;
                                foreach ($shapesCountAutomated as $shape) {
                                    if ($index++ > 4) break;


                                    echo "        <div class=\"kt-widget14__legend\">
                                <span style='background-color:{$shape["color"]}!important;' class=\"kt-widget14__bullet\"></span>
                                <span class=\"kt-widget14__stats\">" . ($shape["count"] ? round((($shape["count"] / $total_generated_shapes) * 100), 1) : 0) . "% {$shape["pretty_name"]}</span>
                            </div>";


                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:: Widgets/Revenue Change-->            </div>
        </div>


        <div class="col-lg-12">
            <!--begin::Portlet-->
            <div class="kt-portlet kt-portlet--tab">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon kt-hidden">
                        <i class="la la-gear"></i>
                    </span>
                        <h3 class="kt-portlet__head-title">
                            <?= Yii::t("app", "Quantifications Average Results") ?>
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div id="conclusions_by_date" style="height:500px;"></div>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
