<div class="h-[320px]">

    <canvas id="salesChart"></canvas>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx =
        document.getElementById(
            'salesChart'
        );
    const chartData =

        @json($chartValues);

    const allZero =

        chartData.every(
            value => value === 0
        );

    new Chart(

        ctx,

        {

            type: 'line',

            data: {

                labels: @json($chartLabels),

                datasets: [{

                    label: 'Revenue',

                    data: @json($chartValues),

                    fill: true,

                    backgroundColor: 'rgba(59,130,246,0.15)',

                    borderColor: '#3b82f6',

                    pointBackgroundColor: '#3b82f6',

                    pointBorderColor: '#3b82f6',

                    pointRadius: 5,

                    pointHoverRadius: 7,

                    borderWidth: 3,

                    tension: 0.45,

                    spanGaps: true

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {

                        labels: {

                            color: '#a1a1aa',

                            font: {

                                size: 13

                            }

                        }

                    },

                    tooltip: {

                        backgroundColor: '#18181b',

                        titleColor: '#fff',

                        bodyColor: '#d4d4d8',

                        padding: 12,

                        displayColors: false,

                        callback: function(value) {

                            if (value >= 1000000) {

                                return 'Rp ' +

                                    (value / 1000000)
                                    .toFixed(1)

                                    +
                                    'M';

                            }

                            if (value >= 1000) {

                                return 'Rp ' +

                                    (value / 1000)
                                    .toFixed(0)

                                    +
                                    'K';

                            }

                            return 'Rp ' +

                                value.toLocaleString(
                                    'id-ID'
                                );

                        }

                    }

                },

                scales: {
                    x: {

                        offset: true,

                        grid: {

                            color: function() {

                                return document.documentElement.classList.contains('dark')

                                    ?

                                    'rgba(255,255,255,0.05)'

                                    :

                                    'rgba(0,0,0,0.05)';

                            }

                        },

                        ticks: {

                            color: function() {

                                return document.documentElement.classList.contains('dark')

                                    ?

                                    '#a1a1aa'

                                    :

                                    '#52525b';

                            }

                        }

                    },

                    y: {

                        beginAtZero: true,

                        suggestedMax: allZero ? 100 : undefined,

                        grid: {

                            color: function() {

                                return document
                                    .documentElement
                                    .classList
                                    .contains(
                                        'dark'
                                    )

                                    ?

                                    'rgba(255,255,255,0.15)'

                                    :

                                    'rgba(0,0,0,0.08)';

                            },

                            drawBorder: false

                        },

                        ticks: {

                            color: function() {

                                return document
                                    .documentElement
                                    .classList
                                    .contains(
                                        'dark'
                                    )

                                    ?

                                    '#a1a1aa'

                                    :

                                    '#52525b';

                            },

                            callback: function(value) {

                                if (value === 0) {

                                    return 'Rp 0';

                                }

                                if (value >= 1000000) {

                                    return 'Rp ' +

                                        (value / 1000000)
                                        .toFixed(1)

                                        +
                                        'M';

                                }

                                if (value >= 1000) {

                                    return 'Rp ' +

                                        (value / 1000)
                                        .toFixed(0)

                                        +
                                        'K';

                                }

                                return 'Rp ' + value;

                            }

                        }

                    }

                }

            }

        }

    );
</script>
