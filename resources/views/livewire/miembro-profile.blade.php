<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Perfil de Miembro: {{ $miembro->fullName }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex"><div><p class="text-sm">{{ session('message') }}</p></div></div>
                </div>
            @endif

            @if($isRenewalModalOpen)
                @include('livewire.miembro-renewal-modal')
            @endif

            {{-- Card de Información del Miembro --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6 sm:px-10 bg-white dark:bg-gray-800">
                    <div class="flex flex-wrap">
                        <div class="w-full sm:w-1/4">
                            <img src="{{ $miembro->foto_path ? asset('storage/' . $miembro->foto_path) : asset('img/default-avatar.png') }}" alt="Foto" class="h-40 w-40 rounded-full object-cover">
                        </div>
                        <div class="w-full sm:w-3/4 sm:pl-8">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $miembro->fullName }}</h3>
                                    <p class="text-sm text-gray-500">{{ $miembro->documento_identidad }}</p>
                                </div>
                                <div class="text-right">
                                    <button wire:click="openRenewalModal" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Renovar Membresía
                                    </button>
                                </div>
                            </div>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <p><strong>Email:</strong> {{ $miembro->email ?? 'N/A' }}</p>
                                <p><strong>Teléfono:</strong> {{ $miembro->telefono ?? 'N/A' }}</p>
                                <p><strong>Fecha de Nacimiento:</strong> {{ $miembro->fecha_nacimiento->format('d/m/Y') }}</p>
                                <p><strong>Sucursal Principal:</strong> {{ $miembro->sucursal->nombre }}</p>
                                <p class="md:col-span-2"><strong>Dirección:</strong> {{ $miembro->direccion ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Historial de Membresías --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4">Historial de Membresías</h3>
                    <table class="table-auto w-full text-sm">
                        <thead><tr class="bg-gray-100 dark:bg-gray-700"><th class="px-4 py-2 text-left">Plan</th><th class="px-4 py-2 text-left">Inicio</th><th class="px-4 py-2 text-left">Fin</th><th class="px-4 py-2 text-left">Estado</th><th class="px-4 py-2 text-left">Monto</th></tr></thead>
                        <tbody>
                            @forelse($miembro->membresias->sortByDesc('fecha_inicio') as $membresia)
                            <tr class="border-b dark:border-gray-700"><td class="px-4 py-2">{{ $membresia->tipoMembresia->nombre }}</td><td class="px-4 py-2">{{ $membresia->fecha_inicio->format('d/m/Y') }}</td><td class="px-4 py-2">{{ $membresia->fecha_fin->format('d/m/Y') }}</td><td class="px-4 py-2">{{ ucfirst($membresia->estado) }}</td><td class="px-4 py-2">${{ number_format($membresia->monto_pagado, 2) }}</td></tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4">No hay membresías registradas.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Historial de Pagos --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4">Historial de Pagos</h3>
                    <table class="table-auto w-full text-sm">
                        <thead><tr class="bg-gray-100 dark:bg-gray-700"><th class="px-4 py-2 text-left">Fecha de Pago</th><th class="px-4 py-2 text-left">Monto</th><th class="px-4 py-2 text-left">Método</th><th class="px-4 py-2 text-left">Membresía</th></tr></thead>
                        <tbody>
                            @php
                                $allPagos = $miembro->membresias->flatMap(fn($m) => $m->pagos)->sortByDesc('fecha_pago');
                            @endphp
                            @forelse($allPagos as $pago)
                            <tr class="border-b dark:border-gray-700"><td class="px-4 py-2">{{ $pago->fecha_pago->format('d/m/Y H:i') }}</td><td class="px-4 py-2">${{ number_format($pago->monto, 2) }}</td><td class="px-4 py-2">{{ $pago->metodo_pago }}</td><td class="px-4 py-2">{{ $pago->membresia->tipoMembresia->nombre }} ({{ $pago->membresia->fecha_inicio->format('d/m/Y') }})</td></tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-4">No hay pagos registrados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
