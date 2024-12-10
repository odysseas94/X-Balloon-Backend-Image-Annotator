$(document).ready(function () {
    dailySales();
    profitShare();
    revenueChange();
    console.log("ready")
})


var dailySales = function () {
    var chartContainer = KTUtil.getByID('kt_chart_daily_sales');

    if (!chartContainer) {
        return;
    }

    var chartData = {
        labels: ["Label 1", "Label 2", "Label 3", "Label 4", "Label 5", "Label 6", "Label 7", "Label 8", "Label 9", "Label 10", "Label 11", "Label 12", "Label 13", "Label 14", "Label 15", "Label 16"],
        datasets: [{
            label: 'Dataset 1',
            backgroundColor: KTApp.getStateColor('success'),
            data: [
                15, 20, 25, 30, 25, 20, 15, 20, 25, 30, 25, 20, 15, 10, 15, 20
            ]
        }, {
            label: 'Dataset 2',
            backgroundColor: '#f3f3fb',
            data: [
                15, 20, 25, 30, 25, 20, 15, 20, 25, 30, 25, 20, 15, 10, 15, 20
            ]
        },
            {
                label: 'Dataset 2',
                backgroundColor: '#f3f3fb',
                data: [
                    151, 201, 251, 301, 251, 201, 151, 201, 251, 301, 251, 201, 151, 101, 151, 201
                ]
            }]
    };

    var chart = new Chart(chartContainer, {
        type: 'bar',
        data: chartData,
        options: {
            title: {
                display: false,
            },
            tooltips: {
                intersect: false,
                mode: 'nearest',
                xPadding: 10,
                yPadding: 10,
                caretPadding: 10
            },
            legend: {
                display: false
            },
            responsive: true,
            maintainAspectRatio: false,
            barRadius: 4,
            scales: {
                xAxes: [{
                    display: false,
                    gridLines: false,
                    stacked: true
                }],
                yAxes: [{
                    display: false,
                    stacked: true,
                    gridLines: false
                }]
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            }
        }
    });
}

var profitShare = function () {
    if (!KTUtil.getByID('kt_chart_profit_share')) {
        return;
    }

    var randomScalingFactor = function () {
        return Math.round(Math.random() * 100);
    };

    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    35, 30, 35
                ],
                backgroundColor: [
                    KTApp.getStateColor('success'),
                    KTApp.getStateColor('danger'),
                    KTApp.getStateColor('brand')
                ]
            }],
            labels: [
                'Angular',
                'CSS',
                'HTML'
            ]
        },
        options: {
            cutoutPercentage: 75,
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
                position: 'top',
            },
            title: {
                display: false,
                text: 'Technology'
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            tooltips: {
                enabled: true,
                intersect: false,
                mode: 'nearest',
                bodySpacing: 5,
                yPadding: 10,
                xPadding: 10,
                caretPadding: 0,
                displayColors: false,
                backgroundColor: KTApp.getStateColor('brand'),
                titleFontColor: '#ffffff',
                cornerRadius: 4,
                footerSpacing: 0,
                titleSpacing: 0
            }
        }
    };

    var ctx = KTUtil.getByID('kt_chart_profit_share').getContext('2d');
    var myDoughnut = new Chart(ctx, config);
}

var revenueChange = function () {
    if ($('#kt_chart_revenue_change').length == 0) {
        return;
    }

    Morris.Donut({
        element: 'kt_chart_revenue_change',
        data: [{
            label: "New York",
            value: 10
        },
            {
                label: "London",
                value: 7
            },
            {
                label: "Paris",
                value: 20
            }
        ],
        colors: [
            KTApp.getStateColor('success'),
            KTApp.getStateColor('danger'),
            KTApp.getStateColor('brand')
        ],
    });
}

