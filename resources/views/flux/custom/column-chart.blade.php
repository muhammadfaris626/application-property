@props([
    'data'
])
<div id="column-chart"></div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</style>
<script>
    // Data untuk chart
    const xData = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    const yData = @json($data); // Nilai untuk y-axis
    // Fungsi untuk format angka ke format Rupiah
    const formatRupiah = (angka) => {
        return "Rp " + new Intl.NumberFormat("id-ID").format(angka);
    };
    const options = {
        series: [
            {
                name: "",
                data: Object.values(yData), // Data y-axis
            }
        ],
        chart: {
            type: "bar",
            height: "250px",
            width: "100%",
            fontFamily: "Inter, sans-serif",
            toolbar: {
                show: false,
            },
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "70%",
                borderRadiusApplication: "end",
                borderRadius: 8,
            },
        },
        tooltip: {
            shared: true,
            intersect: false,
            style: {
                fontFamily: "Inter, sans-serif",
            },
            y: {
                formatter: (value) => {
                    return formatRupiah(value); // Format nilai tooltip ke Rupiah
                }
            }
        },
        states: {
            hover: {
                filter: {
                    type: "darken",
                    value: 1,
                },
            },
        },
        stroke: {
            show: true,
            width: 0,
            colors: ["transparent"],
        },
        grid: {
            show: false,
            strokeDashArray: 4,
            padding: {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            },
        },
        dataLabels: {
            enabled: false,
            formatter: (value) => formatRupiah(value),
        },
        legend: {
            show: false,
        },
        xaxis: {
            categories: xData, // Data untuk x-axis (kategori)
            floating: false,
            labels: {
                show: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                }
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            show: false,
        },
        fill: {
            opacity: 1,
        },
    }

    // Inisialisasi dan render chart jika element ada
    if(document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("column-chart"), options);
        chart.render();
    }
</script>
