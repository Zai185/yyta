<x-filament::card>
    <h2 class="text-lg font-bold mb-4">Exam Average Scores by Date</h2>

    <canvas id="examScatterChart" height="300"></canvas>
</x-filament::card>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('examScatterChart').getContext('2d');

            const chart = new Chart(ctx, {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'Average Score',
                        data: @json($this->data),
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'linear',
                            position: 'bottom',
                            title: {
                                display: true,
                                text: 'Exam Date'
                            },
                            ticks: {
                                callback: function(value, index) {
                                    const labels = @json($this->labels);
                                    return labels[index] ?? '';
                                },
                                stepSize: 1
                            }
                        },
                        y: {
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Average Score'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const labels = @json($this->labels);
                                    return `${labels[context.dataIndex]}: ${context.raw.y}`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
