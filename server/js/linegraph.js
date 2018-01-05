$(function() {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('YYYY-MM-DD HH:mm:ss') + ' - ' + end.format('YYYY-MM-DD HH:mm:ss'));
		ajaxLoadChart(start, end);
    }

    ajaxLoadChart(start, end);

    $('#reportrange').daterangepicker({
        locale: {
            firstDay: 1
        },
        showDropdowns: true,
        timePicker: true,
        timePicker24Hour: true,
        showWeekNumbers: true,
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment().startOf('day'), moment().add(1, 'day').startOf('day')],
            'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().startOf('day')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment().startOf('day')],
            'Last 30 Days': [moment().subtract(29, 'days'), moment().startOf('day')],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    function ajaxLoadChart(start, end) {
        $.getJSON("data.php", {

            startDate: start.format("YYYYMMDDHHMMSS"),
            endDate: end.format("YYYYMMDDHHMMSS"),

        }, function(data) {

            console.log(data);

            var sensor_id = [];
            var timedateNoDupe = [];
            var timedate = [];
            var value1 = [];
            var value2 = [];

            for (var i in data)
                timedate.push(data[i].timedate);

            timedateNoDupe = Array.from(new Set(timedate));

            console.log(timedateNoDupe);

            for (var i in data) {
                for (var y = 0; y < timedateNoDupe.length; y++) {
                    if (data[i].timedate == timedateNoDupe[y]) {
                        if (data[i].sensor_id == '1') {
                            sensor_id.push(data[i].sensor_id);
                            value1.push(data[i].value);
                        } else {
                            value1.push("NaN");
                        }
                        if (data[i].sensor_id == '2') {
                            sensor_id.push(data[i].sensor_id);
                            value2.push(data[i].value);
                        } else {
                            value2.push("NaN");
                        }
                    }
                }
            }

            var chartdata = {
                labels: timedateNoDupe,
                datasets: [{
                        label: "Temperature 'C",
                        fill: false,
                        lineTension: 0.1,
                        backgroundColor: "rgba(59, 89, 152, 0.75)",
                        borderColor: "rgba(59, 89, 152, 1)",
                        pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
                        pointHoverBorderColor: "rgba(59, 89, 152, 1)",
                        data: value1
                    },
                    {
                        label: "Humidity %",
                        fill: false,
                        lineTension: 0.1,
                        backgroundColor: "rgba(29, 202, 255, 0.75)",
                        borderColor: "rgba(29, 202, 255, 1)",
                        pointHoverBackgroundColor: "rgba(29, 202, 255, 1)",
                        pointHoverBorderColor: "rgba(29, 202, 255, 1)",
                        data: value2
                    }
                ]
            };

            var options = {
                responsive: true,
                animation: {
                    duration: 0,
                },
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                hover: {
                    mode: 'nearest',
                    animationDuration: 0,
                },
                responsiveAnimationDuration: 0,
            };
            var ctx = $("#mycanvas");

            if (window.LineGraph != undefined)
                window.LineGraph.destroy();

            window.LineGraph = new Chart(ctx, {
                type: 'line',
                data: chartdata,
                options: options,
            });

        });
    }
});