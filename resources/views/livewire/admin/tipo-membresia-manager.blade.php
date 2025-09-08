<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Tipos de Membresía') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                @if (session()->has('message'))
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                        <div class="flex"><div><p class="text-sm">{{ session('message') }}</p></div></div>
                    </div>
                @endif

                <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Crear Nuevo Tipo</button>

                @if($isModalOpen)
                    @include('livewire.admin.tipo-membresia-modal')
                @endif

                <table class="table-auto w-full">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Nombre</th>
                            <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Precio</th>
                            <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Duración (Días)</th>
                            <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Estado</th>
                            <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tipos as $tipo)
                        <tr class="text-gray-700 dark:text-gray-300">
                            <td class="border px-4 py-2">{{ $tipo->nombre }}</td>
                            <td class="border px-4 py-2">{{ $appSettings['currency_symbol'] ?? '$' }}{{ number_format($tipo->precio, 2) }}</td>
                            <td class="border px-4 py-2">{{ $tipo->duracion_en_dias }}</td>
                            <td class="border px-4 py-2">
                                <span class="{{ $tipo->activo ? 'bg-green-500' : 'bg-red-500' }} text-white text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">
                                    {{ $tipo->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="border px-4 py-2">
                                <button wire:click="edit({{ $tipo->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Editar</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $tipos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
