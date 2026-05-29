<div class="w-full">
    <div class="relative">
        

        <!-- Chart container with horizontal scroll -->
        <div class="overflow-x-auto overflow-y-hidden -mx-6 md:-mx-7 px-6 md:px-7 scrollbar-thin scrollbar-thumb-zinc-300 dark:scrollbar-thumb-zinc-700 scrollbar-track-transparent">
            <div class="min-w-full lg:w-full" :style="window.innerWidth < 1024
        ? 'min-width:700px'
        : ''">
                <div class="h-80 sm:h-96 pr-4">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('salesChart');
    const chartData = @json($chartValues);
    const allZero = chartData.every(value => value === 0);

    // Determine chart width based on number of data points
    const labels = @json($chartLabels);
    const dataPointCount = labels.length;
    const isSmallScreen = window.innerWidth < 1024;
    
    // Set minimum width to ensure scrollability on small screens
    let chartMinWidth = isSmallScreen ? Math.max(500, dataPointCount * 80) : 'auto';

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue',
                data: chartData,
                fill: true,
                backgroundColor: 'rgba(59,130,246,0.1)',
                borderColor: '#3b82f6',
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 7,
                borderWidth: 2.5,
                tension: 0.4,
                spanGaps: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: function() {
                            return document.documentElement.classList.contains('dark')
                                ? '#d4d4d8'
                                : '#52525b';
                        },
                        font: {
                            size: 12,
                            weight: '500'
                        },
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: function() {
                        return document.documentElement.classList.contains('dark')
                            ? '#18181b'
                            : '#ffffff';
                    },
                    titleColor: '#fff',
                    bodyColor: function() {
                        return document.documentElement.classList.contains('dark')
                            ? '#d4d4d8'
                            : '#3f3f46';
                    },
                    borderColor: function() {
                        return document.documentElement.classList.contains('dark')
                            ? '#27272a'
                            : '#e4e4e7';
                    },
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            let value = context.parsed.y;
                            if (value >= 1000000) {
                                return 'Revenue: Rp ' + (value / 1000000).toFixed(1) + 'M';
                            }
                            if (value >= 1000) {
                                return 'Revenue: Rp ' + (value / 1000).toFixed(0) + 'K';
                            }
                            return 'Revenue: Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    offset: true,
                    grid: {
                        color: function() {
                            return document.documentElement.classList.contains('dark')
                                ? 'rgba(255,255,255,0.05)'
                                : 'rgba(0,0,0,0.05)';
                        },
                        drawBorder: false
                    },
                    ticks: {
                        color: function() {
                            return document.documentElement.classList.contains('dark')
                                ? '#a1a1aa'
                                : '#71717a';
                        },
                        font: {
                            size: 11
                        },
                        padding: 8
                    }
                },
                y: {
                    beginAtZero: true,
                    suggestedMax: allZero ? 100 : undefined,
                    grid: {
                        color: function() {
                            return document.documentElement.classList.contains('dark')
                                ? 'rgba(255,255,255,0.05)'
                                : 'rgba(0,0,0,0.05)';
                        },
                        drawBorder: false
                    },
                    ticks: {
                        color: function() {
                            return document.documentElement.classList.contains('dark')
                                ? '#a1a1aa'
                                : '#71717a';
                        },
                        font: {
                            size: 11
                        },
                        padding: 10,
                        callback: function(value) {
                            if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000).toFixed(0) + 'M';
                            }
                            if (value >= 1000) {
                                return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                            }
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 750,
                easing: 'easeInOutQuart'
            }
        }
    });

    // Update chart on window resize
    window.addEventListener('resize', () => {
        if (ctx.chart) {
            ctx.chart.resize();
        }
    });
</script>

<style>
    /* Custom scrollbar styling */
    .scrollbar-thin::-webkit-scrollbar {
        height: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        border-radius: 3px;
        background: #d4d4d8;
    }

    .dark .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #52525b;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #a1a1aa;
    }

    .dark .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #71717a;
    }
</style>
