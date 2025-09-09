<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel Principal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- KPIs --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Ingresos del Mes</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ ($appSettings['currency_symbol'] ?? '$') . number_format($ingresosDelMes, 2) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Nuevos Miembros (Mes)</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $nuevosMiembrosDelMes }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Asistencias de Hoy</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $asistenciasHoy }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Membresías por Vencer (7 días)</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $membresiasPorVencer }}</p>
                </div>
            </div>

            {{-- Gráficos --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Ingresos de los últimos 30 días</h3>
                    <canvas id="ingresosChart"></canvas>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Asistencias de los últimos 30 días</h3>
                    <canvas id="asistenciasChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            const chartOptions = {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: document.documentElement.classList.contains('dark') ? 'rgba(255,255,255,0.7)' : 'rgba(0,0,0,0.7)' }
                    },
                    x: {
                        ticks: { color: document.documentElement.classList.contains('dark') ? 'rgba(255,255,255,0.7)' : 'rgba(0,0,0,0.7)' }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: document.documentElement.classList.contains('dark') ? 'rgba(255,255,255,0.7)' : 'rgba(0,0,0,0.7)'
                        }
                    }
                }
            };

            // Gráfico de Ingresos
            const ingresosCtx = document.getElementById('ingresosChart');
            if (ingresosCtx) {
                new Chart(ingresosCtx, {
                    type: 'line',
                    data: {
                        labels: @json($ingresosChartData['labels']),
                        datasets: [{
                            label: 'Ingresos',
                            data: @json($ingresosChartData['data']),
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    },
                    options: chartOptions
                });
            }

            // Gráfico de Asistencias
            const asistenciasCtx = document.getElementById('asistenciasChart');
            if (asistenciasCtx) {
                new Chart(asistenciasCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($asistenciasChartData['labels']),
                        datasets: [{
                            label: 'Asistencias',
                            data: @json($asistenciasChartData['data']),
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgb(54, 162, 235)',
                            borderWidth: 1
                        }]
                    },
                    options: chartOptions
                });
            }
        });
    </script>
    @endpush
</div>
