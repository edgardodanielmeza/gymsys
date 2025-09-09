<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Historial de Pagos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                {{-- Filtros --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-4 rounded-lg bg-gray-100 dark:bg-gray-700">
                    <div>
                        <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Inicio</label>
                        <input type="date" id="fecha_inicio" wire:model.defer="fecha_inicio" class="mt-1 block w-full rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="fecha_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Fin</label>
                        <input type="date" id="fecha_fin" wire:model.defer="fecha_fin" class="mt-1 block w-full rounded-md shadow-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buscar Miembro</label>
                        <input type="text" id="search" wire:model.live.debounce.300ms="search" class="mt-1 block w-full rounded-md shadow-sm" placeholder="Nombre, apellido o documento...">
                    </div>
                </div>

                 {{-- Total y Botón de Filtrar --}}
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">
                        Total del Periodo: {{ format_money($total_filtrado) }}
                    </h3>
                    <button wire:click="filter" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Filtrar
                    </button>
                </div>

                {{-- Tabla de Pagos --}}
                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-600">
                                <th class="px-4 py-2 text-left">Fecha</th>
                                <th class="px-4 py-2 text-left">Miembro</th>
                                <th class="px-4 py-2 text-left">Monto</th>
                                <th class="px-4 py-2 text-left">Método</th>
                                <th class="px-4 py-2 text-left">Sucursal</th>
                                <th class="px-4 py-2 text-left">Registrado por</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pagos as $pago)
                            <tr class="text-gray-700 dark:text-gray-300 border-b dark:border-gray-700">
                                <td class="px-4 py-2">{{ $pago->fecha_pago->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-2">{{ $pago->membresia->miembro->fullName ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ format_money($pago->monto) }}</td>
                                <td class="px-4 py-2">{{ $pago->metodo_pago }}</td>
                                <td class="px-4 py-2">{{ $pago->membresia->sucursal->nombre ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $pago->usuario->name ?? 'Sistema' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td class="px-4 py-2 text-center" colspan="6">No se encontraron pagos para el periodo seleccionado.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $pagos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
