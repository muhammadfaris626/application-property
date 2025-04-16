@props([
    'label',
    'data',
    'title',
    'category',
    'useRupiah' => true
])
<div id="{{ $label }}" x-data x-init='barComponent(@json($data), "{{ $label }}", @json($title), @json($category), @json($useRupiah))'></div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    function barComponent(data, label, title, category, useRupiah = true) {
        const chart = new ApexCharts(document.querySelector(`#${label}`), {
            series: data,
            chart: {
                type: 'bar',
                height: 350,
                stacked: true,
                stackType: '100%',
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                },
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            title: {
                text: title,
                align: 'center'
            },
            xaxis: {
                categories: category,
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return useRupiah
                            ? "Rp " + new Intl.NumberFormat("id-ID").format(val)
                            : new Intl.NumberFormat("id-ID").format(val);
                    }
                }
            },
            fill: {
                opacity: 1
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                offsetX: 40
            }
        });

        chart.render();
        Livewire.on('updateChart', (newData) => {
            chart.updateSeries(newData);
        });
    }
</script>
