<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Caja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex"><div><p class="text-sm">{{ session('message') }}</p></div></div>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex"><div><p class="text-sm">{{ session('error') }}</p></div></div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if ($cajaAbierta)
                    {{-- VISTA PARA CERRAR CAJA --}}
                    <h3 class="text-2xl font-bold">Caja Abierta</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
                        <p><strong>Abierta por:</strong> {{ $cajaAbierta->user->name }}</p>
                        <p><strong>Fecha de Apertura:</strong> {{ $cajaAbierta->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Monto Inicial:</strong> {{ $appSettings['currency_symbol'] ?? '$' }}{{ number_format($cajaAbierta->monto_inicial, 2) }}</p>
                        <p><strong>Ventas en Efectivo:</strong> {{ $appSettings['currency_symbol'] ?? '$' }}{{ number_format($total_ventas_efectivo, 2) }}</p>
                        <p class="font-bold text-lg">Monto Calculado en Caja: {{ $appSettings['currency_symbol'] ?? '$' }}{{ number_format($cajaAbierta->monto_inicial + $total_ventas_efectivo, 2) }}</p>
                    </div>

                    <form wire:submit.prevent="cerrarCaja" class="mt-6 border-t dark:border-gray-700 pt-6">
                        <h4 class="text-xl font-semibold mb-4">Cerrar Turno</h4>
                        <div class="mb-4">
                            <label for="monto_final_real" class="block text-sm font-bold">Monto Final Real (Conteo de efectivo)</label>
                            <input type="number" step="0.01" id="monto_final_real" wire:model.defer="monto_final_real" class="mt-1 block w-full rounded-md shadow-sm">
                            @error('monto_final_real') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>
                         <div class="mb-4">
                            <label for="notas_cierre" class="block text-sm font-bold">Notas de Cierre</label>
                            <textarea id="notas_cierre" wire:model.defer="notas_cierre" class="mt-1 block w-full rounded-md shadow-sm"></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Cerrar Caja
                            </button>
                        </div>
                    </form>

                @else
                    {{-- VISTA PARA ABRIR CAJA --}}
                    <h3 class="text-2xl font-bold">Abrir Nueva Caja</h3>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Debes abrir una caja para poder registrar ventas en el Punto de Venta.</p>
                    <form wire:submit.prevent="abrirCaja" class="mt-6">
                        <div class="mb-4">
                            <label for="monto_inicial" class="block text-sm font-bold">Monto Inicial en Caja</label>
                            <input type="number" step="0.01" id="monto_inicial" wire:model.defer="monto_inicial" class="mt-1 block w-full rounded-md shadow-sm" autofocus>
                            @error('monto_inicial') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>
                        <div class="text-right">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Abrir Caja
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
