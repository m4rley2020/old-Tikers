var Charts = function (){
    
    if (!jQuery.plot) { return; }
    
    // Function to handel Basic Charts
    var handelBasicChart = function () {
        var d1 = [];
        for (var i = 0; i < Math.PI * 2; i += 0.25) {
            d1.push([i, Math.sin(i)]);
        }

        var d2 = [];
        for (var i = 0; i < Math.PI * 2; i += 0.25) {
            d2.push([i, Math.cos(i)]);
        }


        $.plot("#basicChart", [
            {label: "sin(x)", data: d1, color: '#fd5757'},
            {label: "cos(x)", data: d2, color: '#57a5fd'}
        ], {
            series: {
                lines: {show: true},
                points: {show: true}
            },
            xaxis: {
                ticks: [
                    0, [Math.PI / 2, "\u03c0/2"], [Math.PI, "\u03c0"],
                    [Math.PI * 3 / 2, "3\u03c0/2"], [Math.PI * 2, "2\u03c0"]
                ]
            },
            yaxis: {
                ticks: 10,
                min: -2,
                max: 2,
                tickDecimals: 3
            },
            grid: {
                hoverable: true,
                backgroundColor: {colors: ["#fff", "#fff"]},
                borderWidth: {
                    top: 1,
                    right: 1,
                    bottom: 2,
                    left: 2
                }
            },
            tooltip: true,
            tooltipOpts: {
                content: "'%s' of %x.1 is %y.4",
                shifts: {
                    x: -60,
                    y: 25
                }
            }
        });
    }
    
    // Function For Tracking Curves
    var handelTrackingCurves = function () {
  
        var sin = [],
                cos = [];
        for (var i = 0; i < 14; i += 0.1) {
            sin.push([i, Math.sin(i)]);
            cos.push([i, Math.cos(i)]);
        }

        plot = $.plot($("#trackingCurves"), [{
                data: sin,
                label: "sin(x) = -0.00",
                color: '#fc3636'
            }, {
                data: cos,
                label: "cos(x) = -0.00",
                color: '#76b610'
            }], {
            series: {
                lines: {
                    show: true
                }
            },
            crosshair: {
                mode: "x"
            },
            grid: {
                hoverable: true,
                autoHighlight: false
            },
            yaxis: {
                min: -1.2,
                max: 1.2
            },
            tooltip: true,
            tooltipOpts: {
                content: "'%s' of %x.1 is %y.4",
                shifts: {
                    x: -60,
                    y: 25
                }
            }
        });

        var legends = $("#trackingCurves .legendLabel");
        legends.each(function() {
            // fix the widths so they don't jump around
            $(this).css('width', $(this).width());
        });

        var updateLegendTimeout = null;
        var latestPosition = null;

        function updateLegend() {
            updateLegendTimeout = null;

            var pos = latestPosition;

            var axes = plot.getAxes();
            if (pos.x < axes.xaxis.min || pos.x > axes.xaxis.max || pos.y < axes.yaxis.min || pos.y > axes.yaxis.max)
                return;

            var i, j, dataset = plot.getData();
            for (i = 0; i < dataset.length; ++i) {
                var series = dataset[i];

                // find the nearest points, x-wise
                for (j = 0; j < series.data.length; ++j)
                    if (series.data[j][0] > pos.x)
                        break;

                // now interpolate
                var y, p1 = series.data[j - 1],
                        p2 = series.data[j];
                if (p1 == null)
                    y = p2[1];
                else if (p2 == null)
                    y = p1[1];
                else
                    y = p1[1] + (p2[1] - p1[1]) * (pos.x - p1[0]) / (p2[0] - p1[0]);

                legends.eq(i).text(series.label.replace(/=.*/, "= " + y.toFixed(2)));
            }
        }

        $("#trackingCurves").bind("plothover", function(event, pos, item) {
            latestPosition = pos;
            if (!updateLegendTimeout)
                updateLegendTimeout = setTimeout(updateLegend, 50);
        });
    }
    
    // Function to handel Bar Chart
    var handelBarChart = function () {
        var dataforBar = [
            {
                data: [[0, 4]],
                color: "#57a5fd"
            },
            {
                data: [[1, 1]],
                color: "#d09d2e"
            },
            {
                data: [[2, 2]],
                color: "#1bd0fd"
            },
            {
                data: [[3, 4]],
                color: "#64891b"
            },
            {
                data: [[4, 3]],
                color: "#fe7e00"
            },
            {
                data: [[5, 5]],
                color: "#815394"
            }
        ];

        $.plot($("#barChart"), dataforBar, {
            series: {
                lines: {
                    fill: false
                },
                points: {show: false},
                bars: {
                    show: true,
                    align: 'center',
                    barWidth: 0.5,
                    fill: 1,
                    lineWidth: 1
                }
            },
            xaxis: {
                tickLength: 0,
                ticks: [
                    [0, "Rating 5"],
                    [1, "Rating 4"],
                    [2, "Rating 3"],
                    [3, "Rating 2"],
                    [4, "Rating 1"],
                    [5, "Not Closed"]]
            },
            yaxis: {
                min: 0
            },
            grid: {
                borderWidth: 0,
                hoverable: true
            },
            tooltip: true,
            tooltipOpts: {
                content: "x: %x, y: %y"
            }
        });
    }
    
    
    //  Function To handel Multi Bar Chart
    var handelMultiBarChart = function() {
         var d1_1 = [
            [1325376000000, 120],
            [1328054400000, 70],
            [1330560000000, 100],
            [1333238400000, 60],
            [1335830400000, 35]
        ];

        var d1_2 = [
            [1325376000000, 80],
            [1328054400000, 60],
            [1330560000000, 30],
            [1333238400000, 35],
            [1335830400000, 30]
        ];

        var d1_3 = [
            [1325376000000, 80],
            [1328054400000, 40],
            [1330560000000, 30],
            [1333238400000, 20],
            [1335830400000, 10]
        ];

        var d1_4 = [
            [1325376000000, 15],
            [1328054400000, 10],
            [1330560000000, 15],
            [1333238400000, 20],
            [1335830400000, 15]
        ];

        var data1 = [
            {
                label: "Product 1",
                data: d1_1,
                bars: {
                    show: true,
                    barWidth: 12 * 24 * 60 * 60 * 300,
                    fill: true,
                    lineWidth: 1,
                    order: 1,
                    fillColor: "#8db02e"
                },
                color: "#8db02e"
            },
            {
                label: "Product 2",
                data: d1_2,
                bars: {
                    show: true,
                    barWidth: 12 * 24 * 60 * 60 * 300,
                    fill: true,
                    lineWidth: 1,
                    order: 2,
                    fillColor: "#6979b2"
                },
                color: "#6979b2"
            },
            {
                label: "Product 3",
                data: d1_3,
                bars: {
                    show: true,
                    barWidth: 12 * 24 * 60 * 60 * 300,
                    fill: true,
                    lineWidth: 1,
                    order: 3,
                    fillColor: "#b74377"
                },
                color: "#b74377"
            },
            {
                label: "Product 4",
                data: d1_4,
                bars: {
                    show: true,
                    barWidth: 12 * 24 * 60 * 60 * 300,
                    fill: true,
                    lineWidth: 1,
                    order: 4,
                    fillColor: "#cdb321"
                },
                color: "#cdb321"
            }
        ];

        $.plot($("#multiBarChart"), data1, {
            xaxis: {
                min: (new Date(2011, 11, 15)).getTime(),
                max: (new Date(2012, 04, 18)).getTime(),
                mode: "time",
                timeformat: "%b",
                tickSize: [1, "month"],
                monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                tickLength: 0, // hide gridlines
                axisLabel: 'Month',
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelPadding: 5
            },
            yaxis: {
                axisLabel: 'Value',
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelPadding: 5
            },
            grid: {
                hoverable: true,
                clickable: false,
                borderWidth: 1
            },
            tooltip: true,
            tooltipOpts: {
                content: "Sales: %y"
            },
            legend: {
                labelBoxBorderColor: "none",
                position: "left"
            },
            series: {
                shadowSize: 1
            }
        });
    }
    
    //  Function To Handel Pie Chart
    var handelPieChart = function () {
        var dataforPie = [
            {
                label: "Not Completed",
                data: 150,
                color: "#ff0036"
            },
            {
                label: "Rating 1",
                data: 100,
                color: "#fe7e00"
            },
            {
                label: "Rating 2",
                data: 250,
                color: "#febf00"
            },
            {
                label: "Rating 3",
                data: 250,
                color: "#1bd0fd"
            },
            {
                label: "Rating 4",
                data: 250,
                color: "#b1bf12"
            },
            {
                label: "Rating 5",
                data: 250,
                color: "#74b61a"
            }
        ];

        var options = {
            series: {
                pie: {
                    show: true
                }
            },
            grid: {
                hoverable: true
            },
            tooltip: true,
            tooltipOpts: {
                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: false
            },
            legend: {
                show: true
            }
        };

        $.plot($("#pieChart"), dataforPie, options);
    }

    // Function To handel Donut Chart
    var handelDonetChart = function () {
        var dataforPie = [
            {
                label: "Not Completed",
                data: 150,
                color: "#ff0036"
            },
            {
                label: "Rating 1",
                data: 100,
                color: "#fe7e00"
            },
            {
                label: "Rating 2",
                data: 250,
                color: "#febf00"
            },
            {
                label: "Rating 3",
                data: 250,
                color: "#1bd0fd"
            },
            {
                label: "Rating 4",
                data: 250,
                color: "#b1bf12"
            },
            {
                label: "Rating 5",
                data: 250,
                color: "#74b61a"
            }
        ];

        var options = {
            series: {
                pie: {
                    innerRadius: 0.5,
                    show: true
                }
            },
            grid: {
                hoverable: true
            },
            tooltip: true,
            tooltipOpts: {
                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: false
            },
            legend: {
                show: true
            }
        };

        $.plot($("#donutChart"), dataforPie, options);
    }
    
    // Function to Handel Area Chart
    var handleAreaChart = function() {
        var d1 = [[1262304000000, 6], [1264982400000, 3057], [1267401600000, 20434], [1270080000000, 31982], [1272672000000, 26602], [1275350400000, 27826], [1277942400000, 24302], [1280620800000, 24237], [1283299200000, 21004], [1285891200000, 12144], [1288569600000, 10577], [1291161600000, 10295]];
        var d2 = [[1262304000000, 5], [1264982400000, 200], [1267401600000, 1605], [1270080000000, 6129], [1272672000000, 11643], [1275350400000, 19055], [1277942400000, 30062], [1280620800000, 39197], [1283299200000, 37000], [1285891200000, 27000], [1288569600000, 21000], [1291161600000, 17000]];

        var data1 = [
            {label: "Sales One", data: d1, points: {fillColor: "#ff825c", size: 5}, color: '#ff6e42'},
            {label: "Sales Two", data: d2, points: {fillColor: "#a3cf64", size: 5}, color: '#7ac70c'}
        ];
        
        $.plot($("#areaChart"), data1, {
            xaxis: {
                min: (new Date(2009, 12, 1)).getTime(),
                max: (new Date(2010, 11, 1)).getTime(),
                mode: "time",
                tickSize: [1, "month"],
                monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                tickLength: 0,
                axisLabel: 'Month',
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelPadding: 5
            },
            yaxis: {
                axisLabel: 'Amount',
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelPadding: 5
            },
            series: {
                lines: {
                    show: true,
                    fill: true
                },
                points: {
                    show: false
                }                               
            },
            
            grid: {
                borderWidth: 1,
                hoverable: true 
            },
            tooltip: true,
            tooltipOpts: {
                content: "Sales: %y"
            },
            legend: {
                labelBoxBorderColor: "none",
                position: "left"
            }
        });
    };
    
    // Function To handel Tilted Pie
    var handelTiltedPie = function (){
        var dataforPie = [
            {
                label: "Not Completed",
                data: 150,
                color: "#ff0036"
            },
            {
                label: "Rating 1",
                data: 100,
                color: "#fe7e00"
            },
            {
                label: "Rating 2",
                data: 250,
                color: "#febf00"
            },
            {
                label: "Rating 3",
                data: 250,
                color: "#1bd0fd"
            },
            {
                label: "Rating 4",
                data: 250,
                color: "#b1bf12"
            },
            {
                label: "Rating 5",
                data: 250,
                color: "#74b61a"
            }
        ];

        var options = {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    tilt: 0.5
                }
            },
            grid: {
                hoverable: true
            },
            tooltip: true,
            tooltipOpts: {
                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: false
            },
            legend: {
                show: true
            }
        };

        $.plot($("#TiltedPie"), dataforPie, options);
    }
    
    
    return {
        init: function() {
            handelBasicChart();
            handelTrackingCurves();
            handelBarChart();
            handelMultiBarChart();
            handelPieChart();
            handelDonetChart();
            handleAreaChart();
            handelTiltedPie();
        }
        
    }
}();    // Charts




