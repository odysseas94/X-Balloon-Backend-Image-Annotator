$(document).ready(function () {


    shapesCountGroupByDate();
    shapesCountF();
    shapesCountAutomatedF();
    conclusionsByDate();
})


let shapesCountGroupByDate = function () {
    let chartContainer = KTUtil.getByID('kt_chart_daily_saved_findings');
    // "{"fat":{"values":[{"count":4,"date":"2020-05-14"}],"pretty_name":"Fat","color":"#af8a53"},"ballooning":{"values":[{"count":1,"date":"2020-05-15"}],"pretty_name":"Ballooning","color":"#1abc9c"}}"
    const {shapesContByDate} = window.models;
    let datasets = [];
    let labels = [];
    for (let i = 15; i >= 0; i--) labels.push(moment(new Date).add(-i, "days").format("YYYY-MM-DD"))

    if (shapesContByDate) {

        for (let ob in shapesContByDate) {
            let dataset = {};
            let parent = shapesContByDate[ob];
            let values = parent.values;
            dataset.backgroundColor = parent.color
            dataset.label = parent.pretty_name;
            let data = [];

            for (let l in labels) {
                let label = labels[l];
                let found = false;
                for (let v in values) {
                    let value = values[v];


                    if (label === value.date) {
                        found = true;
                        data.push(value.count);
                        break;
                    }
                }
                if (!found) {
                    data.push(0)
                }

            }


            dataset.data = data;
            datasets.push(dataset)
        }

    }
    if (!chartContainer) {
        return;
    }

    let chartData = {
        labels: labels,
        datasets: datasets
    };

    let chart = new Chart(chartContainer, {
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

let shapesCountF = function () {
    if (!KTUtil.getByID('kt_chart_total_saved_findings')) {
        return;
    }

    let randomScalingFactor = function () {
        return Math.round(Math.random() * 100);
    };

    let {shapesCount} = window.models;
    let data = [];
    let backgroundColors = [];
    let labels = [];

    if (shapesCount) {
        for (let ob in shapesCount) {
            let shape = shapesCount[ob];
            data.push(shape.count);
            backgroundColors.push(shape.color);
            labels.push(shape.pretty_name);
        }
    }

    let config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: data,
                backgroundColor: backgroundColors,
            }],
            labels: labels,
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
                backgroundColor: "#2c77f4",
                titleFontColor: '#ffffff',
                cornerRadius: 4,
                footerSpacing: 0,
                titleSpacing: 0
            }
        }
    };

    let ctx = KTUtil.getByID('kt_chart_total_saved_findings').getContext('2d');
    new Chart(ctx, config);
}

let shapesCountAutomatedF = function () {
    if ($('#kt_chart_generated_findings').length == 0) {
        return;
    }
    let {shapesCountAutomated} = window.models;
    let data = [];
    let colors = [];

    if (shapesCountAutomated) {
        for (let ob in shapesCountAutomated) {
            let shape = shapesCountAutomated[ob];
            data.push({
                value: shape.count,

                label: shape.pretty_name
            });
            colors.push(shape.color);

        }
    }
    if (data.length)
        Morris.Donut({
            element: 'kt_chart_generated_findings',
            data: data,
            colors: colors
        });
    else
        Morris.Donut({
            element: 'kt_chart_generated_findings',
        });
}


let conclusionsByDate = function () {
    const {allConclusionsByDate} = window.models;
    let length = allConclusionsByDate.length;
    let data = [];
    for (let i = length - 1; i >= 0; i--) {

        let model = allConclusionsByDate[i];

        data.push({
            date: moment(model.date).format("DD-MMMM"),
            counter: model.counter,
            percentage: model.percentage,
            total_shapes: model.shapes

        })
    }
    console.log(data);

    new Morris.Bar({
        element: 'conclusions_by_date',
        data: data,
        xkey: 'date',
        ykeys: ['counter', 'percentage', 'total_shapes'],
        labels: [translations.counter, translations.percentage, translations.total_shapes],
        barColors: ['#106466', '#5558e3', '#e76f00']
    });

}

