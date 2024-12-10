<?php

/* @var $this yii\web\View */

$this->title = 'Dashboard';


?>
<div class="site-index">

    <div class="row">
        <div class="col-xl-4">
            <!--begin:: Widgets/Daily Sales-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-widget14">
                    <div class="kt-widget14__header kt-margin-b-30">
                        <h3 class="kt-widget14__title">
                            Daily Sales
                        </h3>
                        <span class="kt-widget14__desc">
				Check out each collumn for more details
			</span>
                    </div>
                    <div class="kt-widget14__chart" style="height:120px;">
                        <canvas id="kt_chart_daily_sales"></canvas>
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
                            Profit Share
                        </h3>
                        <span class="kt-widget14__desc">
				Profit Share between customers
			</span>
                    </div>
                    <div class="kt-widget14__content">
                        <div class="kt-widget14__chart">
                            <div class="kt-widget14__stat">45</div>
                            <canvas id="kt_chart_profit_share" style="height: 140px; width: 140px;"></canvas>
                        </div>
                        <div class="kt-widget14__legends">
                            <div class="kt-widget14__legend">
                                <span class="kt-widget14__bullet kt-bg-success"></span>
                                <span class="kt-widget14__stats">37% Sport Tickets</span>
                            </div>
                            <div class="kt-widget14__legend">
                                <span class="kt-widget14__bullet kt-bg-warning"></span>
                                <span class="kt-widget14__stats">47% Business Events</span>
                            </div>
                            <div class="kt-widget14__legend">
                                <span class="kt-widget14__bullet kt-bg-brand"></span>
                                <span class="kt-widget14__stats">19% Others</span>
                            </div>
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
                            Revenue Change
                        </h3>
                        <span class="kt-widget14__desc">
				Revenue change breakdown by cities
			</span>
                    </div>
                    <div class="kt-widget14__content">
                        <div class="kt-widget14__chart">
                            <div id="kt_chart_revenue_change" style="height: 150px; width: 150px;"></div>
                        </div>
                        <div class="kt-widget14__legends">
                            <div class="kt-widget14__legend">
                                <span class="kt-widget14__bullet kt-bg-success"></span>
                                <span class="kt-widget14__stats">+10% New York</span>
                            </div>
                            <div class="kt-widget14__legend">
                                <span class="kt-widget14__bullet kt-bg-warning"></span>
                                <span class="kt-widget14__stats">-7% London</span>
                            </div>
                            <div class="kt-widget14__legend">
                                <span class="kt-widget14__bullet kt-bg-brand"></span>
                                <span class="kt-widget14__stats">+20% California</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end:: Widgets/Revenue Change-->            </div>
    </div>


</div>
