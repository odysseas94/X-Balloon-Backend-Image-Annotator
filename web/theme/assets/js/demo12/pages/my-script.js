var dailySales = function () {
    var chartContainer = KTUtil.getByID('kt_chart_daily_sales');

    if (!chartContainer) {
        return;
    }

    var chartData = {
        labels: ["Label 1", "Label 2", "Label 3", "Label 4", "Label 5", "Label 6", "Label 7", "Label 8", "Label 9", "Label 10", "Label 11", "Label 12", "Label 13", "Label 14", "Label 15", "Label 16"],
        datasets: [{
            //label: 'Dataset 1',
            backgroundColor: KTApp.getStateColor('success'),
            data: [
                15, 20, 25, 30, 25, 20, 15, 20, 25, 30, 25, 20, 15, 10, 15, 20
            ]
        }, {
            //label: 'Dataset 2',
            backgroundColor: '#f3f3fb',
            data: [
                15, 20, 25, 30, 25, 20, 15, 20, 25, 30, 25, 20, 15, 10, 15, 20
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