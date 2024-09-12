function getDonutChartOptions(seriesData, labelsData, customOptions = {}) {
    const defaultConfig = {
        height: 320,
        colors: ["#1C64F2", "#16BDCA", "#FDBA8C", "#E74694"],
        fontFamily: "Inter, sans-serif",
        totalLabel: "",
        showGrid: false,
    };
    const config = { ...defaultConfig, ...customOptions };

    return {
        series: seriesData,
        colors: config.colors,
        chart: {
            height: config.height,
            width: "100%",
            type: "donut",
        },
        stroke: {
            colors: ["transparent"],
            lineCap: "",
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontFamily: config.fontFamily,
                            offsetY: 20,
                        },
                        total: {
                            showAlways: true,
                            show: true,
                            label: config.totalLabel,
                            fontFamily: config.fontFamily,
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            },
                        },
                        value: {
                            show: true,
                            fontFamily: config.fontFamily,
                            offsetY: -20,
                            formatter: function (value) {
                                return value;
                            },
                        },
                    },
                    size: "80%",
                },
            },
        },
        grid: {
            padding: {
                top: -2,
            },
        },
        labels: labelsData,
        dataLabels: {
            enabled: false,
        },
        legend: {
            position: "bottom",
            fontFamily: config.fontFamily,
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return value;
                },
            },
        },
        xaxis: {
            labels: {
                formatter: function (value) {
                    return value;
                },
            },
            axisTicks: {
                show: config.showGrid,
            },
            axisBorder: {
                show: config.showGrid,
            },
        },
    };
}

function getAreaChartOptions(seriesData, labelsData, config = {}) {
    const defaultConfig = {
        height: 180,
        showGrid: true,
        colors: ["#1C64F2"],
        seriesName: "Series 1",
        fontFamily: "Inter, sans-serif",
    };
    const finalConfig = { ...defaultConfig, ...config };

    return {
        chart: {
            height: finalConfig.height,
            width: "100%",
            type: "area",
            fontFamily: finalConfig.fontFamily,
            toolbar: { show: false },
        },
        tooltip: {
            enabled: true,
            x: { show: false },
        },
        fill: {
            type: "gradient",
            gradient: {
                opacityFrom: 0.55,
                opacityTo: 0,
                shade: finalConfig.colors[0],
                gradientToColors: finalConfig.colors,
            },
        },
        dataLabels: { enabled: false },
        stroke: { width: 4 },
        grid: {
            show: finalConfig.showGrid,
            strokeDashArray: 4,
            padding: { left: 2, right: 2, top: -26 },
        },
        series: seriesData.map((item, index) => ({
            name: item.name || finalConfig.seriesName,
            data: item.data,
            color: finalConfig.colors[index] || finalConfig.colors[0],
        })),
        xaxis: {
            categories: labelsData,
            labels: {
                show: finalConfig.showGrid,
                style: {
                    fontFamily: finalConfig.fontFamily,
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                },
            },
            axisBorder: { show: finalConfig.showGrid },
            axisTicks: { show: finalConfig.showGrid },
        },
        yaxis: {
            labels: {
                show: finalConfig.showGrid,
                style: {
                    fontFamily: finalConfig.fontFamily,
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                },
                formatter: finalConfig.yAxisFormatter || null,
            },
        },
    };
}

function getPieChartOptions(seriesData, labelsData, config = {}) {
    const defaultConfig = {
        height: 180,
        colors: ["#16BDCA", "#1C64F2", "#9061F9"],
        fontFamily: "Inter, sans-serif",
    };
    const finalConfig = { ...defaultConfig, ...config };

    return {
        series: seriesData,
        colors: finalConfig.colors,
        chart: {
            height: finalConfig.height,
            width: "100%",
            type: "pie",
        },
        stroke: { colors: ["white"] },
        plotOptions: {
            pie: {
                labels: {
                    show: true,
                },
                size: "100%",
                dataLabels: {
                    offset: -15,
                },
            },
        },
        labels: labelsData,
        dataLabels: {
            enabled: true,
            style: { fontFamily: finalConfig.fontFamily },
        },
        legend: {
            show: false,
            position: "bottom",
            fontFamily: finalConfig.fontFamily,
        },
    };
}
