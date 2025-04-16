@props([
    'label',
    'data',
    'title',
    'useRupiah' => true // default: true, bisa diubah dari Blade
])

<div id="{{ $label }}" x-data x-init='chartComponent(@json($data), "{{ $label }}", @json($title), @json($useRupiah))'></div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    function chartComponent(data, label, title, useRupiah = true) {
        const chart = new ApexCharts(document.querySelector(`#${label}`), {
            series: data,
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 5,
                    borderRadiusApplication: 'end'
                },
            },
            dataLabels: { enabled: false },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            yaxis: {
                title: { text: title }
            },
            fill: { opacity: 1 },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return useRupiah
                            ? "Rp " + new Intl.NumberFormat("id-ID").format(val)
                            : new Intl.NumberFormat("id-ID").format(val);
                    }
                }
            }
        });

        chart.render();

        Livewire?.on?.('updateChart', (newData) => {
            chart.updateSeries(newData);
        });
    }
</script>
