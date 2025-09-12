<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel Principal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- KPIs --}}
             {{-- Fila 1: KPIs de Ingresos --}}
            <div class="mb-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Ingresos Cuotas Hoy --}}

                 <div wire:click="mostrarModal('ingresosCuotasHoy')"  class=" cursor-pointer bg-blue-100 border-4 border-blue-200 border-l-blue-500 hover:border-blue-500  dark:bg-blue-500  border-4 border-blue-500 border-l-blue-800 hover:border-blue-800 overflow-hidden shadow-xl sm:rounded-lg p-4">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-100">Ingresos Cuotas (Hoy)</h3>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ ($appSettings['currency_symbol'] ?? '$') . number_format($ingresosCuotasHoy, 2) }}</p>
                    </div>



                {{-- Ingresos Ventas Hoy --}}
                    <div wire:click="mostrarModal('ingresosVentasHoy')"  class="cursor-pointer bg-violet-200 border-4 border-violet-200 border-l-violet-500 hover:border-violet-500  dark:bg-violet-500 border-4 border-violet-500 border-l-violet-800 hover:border-violet-800 overflow-hidden shadow-xl sm:rounded-lg p-4">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                        </svg>

                       <h3 class="text-lg font-medium text-gray-500 dark:text-gray-100">Ingresos Ventas (Hoy)</h3>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ ($appSettings['currency_symbol'] ?? '$') . number_format($ingresosVentasHoy, 2) }}</p>
                    </div>

                {{-- Ingresos Totales Hoy --}}
                 <div wire:click="mostrarModal('ingresosVentasTotalHoy')"   class="cursor-pointer bg-gray-100 border-4 border-gray-200 border-l-gray-500 hover:border-gray-500  dark:bg-gray-500 border-4 border-gray-500 border-l-gray-800 hover:border-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                         <h3 class="text-lg font-medium text-gray-500 dark:text-gray-100">Ingresos Totales (Hoy)</h3>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ ($appSettings['currency_symbol'] ?? '$') . number_format($ingresosTotalHoy, 2) }}</p>
                </div>




                {{-- Ingresos del Mes --}}
                 <div wire:click="mostrarModal('ingresosDelMes')"   class="cursor-pointer bg-green-100 border-4 border-green-200 border-l-green-500 hover:border-green-500  dark:bg-green-500 border-4 border-green-500 border-l-green-800 hover:border-green-800 overflow-hidden shadow-xl sm:rounded-lg p-4">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v7.5m2.25-6.466a9.016 9.016 0 0 0-3.461-.203c-.536.072-.974.478-1.021 1.017a4.559 4.559 0 0 0-.018.402c0 .464.336.844.775.994l2.95 1.012c.44.15.775.53.775.994 0 .136-.006.27-.018.402-.047.539-.485.945-1.021 1.017a9.077 9.077 0 0 1-3.461-.203M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                          <h3 class="text-lg font-medium text-gray-500 dark:text-gray-100">Ingresos del Mes</h3>
                            <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ ($appSettings['currency_symbol'] ?? '$') . number_format($ingresosDelMes, 2) }}</p>
                </div>




            </div>

            {{-- Fila 2: KPIs Mensuales y Vencimientos --}}

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

                {{-- asistencia hoy --}}
                    <div wire:click="mostrarModal('asistenciasHoy')"  class=" cursor-pointer bg-emerald-100 border-4 border-emerald-200 border-l-emerald-500 hover:border-emerald-500  dark:bg-emerald-500 border-4 border-emerald-500 border-l-emerald-800 hover:border-emerald-800 overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>

                        <h3 class="text-lg font-medium text-gray-500 dark:text-gray-100">Asistencias de Hoy</h3>
                        <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ $asistenciasHoy }}</p>
                    </div>

                  {{-- Nuevos Miembreos hoy --}}
                <div wire:click="mostrarModal('nuevosMiembrosHoy')"  class=" cursor-pointer bg-indigo-100  border-4 border-indigo-200 border-l-indigo-500  hover:border-indigo-500   dark:bg-indigo-800 border-4 border-indigo-800 border-l-indigo-950 hover:border-indigo-950 overflow-hidden shadow-xl sm:rounded-lg p-4">
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-100">Nuevos Miembros (hoy)</h3>
                    <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ $nuevosMiembrosHoy }}</p>
                </div>


                  {{-- Vencimientos Hoy --}}
                 <div wire:click="mostrarModal('vencimientosHoy')"   class="cursor-pointer p-4 overflow-hidden bg-red-100 border-4 border-red-200 border-l-red-500 shadow-xl dark:bg-red-800  border-4 border-red-800 border-l-red-950 hover:border-red-950  sm:rounded-lg hover:border-red-500">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>

                            <h3 class="text-lg font-medium text-gray-500 dark:text-gray-100">Vencimientos Hoy</h3>
                            <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ $vencimientosHoy }}</p>

                </div>

                {{-- Vencimientos 7 dias--}}
                <div wire:click="mostrarModal('membresiasPorVencer')"   class="cursor-pointer bg-orange-100 border-4 border-orange-200 border-l-orange-500 hover:border-orange-500 dark:bg-orange-500   border-4 border-orange-500 border-l-orange-800 hover:border-orange-800 overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"  stroke-width="1.5" stroke="currentColor" class="size-8">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-100"> Venciminetos (7 días)</h3>
                    <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ $membresiasPorVencer }}</p>
                </div>

                {{-- Asistencias del Mes
                <div class="p-4 overflow-hidden bg-teal-100 border-4 border-teal-200 border-l-teal-500 shadow-xl dark:bg-teal-800 sm:rounded-lg hover:border-teal-500">
                     <div class="flex items-center">
                        <div class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m-7.5-2.226A3 3 0 0 1 18 15V6.75a3 3 0 0 0-3-3H9a3 3 0 0 0-3 3v.005M9 18h.01M4.537 20.47a3.001 3.001 0 0 0 4.925 0-3.001 3.001 0 0 0-4.925 0Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Asistencias del Mes</h3>
                            <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">{{ $asistenciasMes }}</p>
                        </div>
                    </div>
                </div> --}}




            </div>

               {{-- Gráficos --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
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


      {{-- Modal para mostrar detalles --}}
    <x-dialog-modal wire:model.live="modalVisible">
        <x-slot name="title">
            {{ $modalTitle }}
        </x-slot>

       <x-slot name="content">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            @foreach($modalHeaders as $header)
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ $header }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                      <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($modalData as $row)
                            <tr>
                                @foreach($row as $cell)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                        {{ $cell }}
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($modalHeaders) }}" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                    No hay datos para mostrar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                Cerrar
            </x-secondary-button>
        </x-slot>

    </x-dialog-modal>

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
