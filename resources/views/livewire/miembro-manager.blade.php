<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Miembros') }}
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

                <div class="flex justify-between items-center mb-4">
                    <div class="w-1/2">
                        <input wire:model.live.debounce.300ms="search" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-900 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline" placeholder="Buscar miembros por nombre, apellido o documento...">
                    </div>
                    <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Registrar Nuevo Miembro
                    </button>
                </div>

                @if($isModalOpen)
                    @include('livewire.miembro-modal')
                @endif

                @if($isRenewalModalOpen)
                    @include('livewire.miembro-renewal-modal')
                @endif

                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white"></th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Nombre Completo</th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Documento</th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Membresía Activa</th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Sucursal Principal</th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Estado</th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($miembros as $miembro)
                            <tr class="text-gray-700 dark:text-gray-300">
                                <td class="border px-4 py-2">
                                    <img src="{{ $miembro->foto_path ? asset('storage/' . $miembro->foto_path) : asset('img/default-avatar.png') }}" alt="Foto" class="h-10 w-10 rounded-full object-cover">
                                </td>
                                <td class="border px-4 py-2">{{ $miembro->fullName }}</td>
                                <td class="border px-4 py-2">{{ $miembro->documento_identidad }}</td>
                                <td class="border px-4 py-2">
                                    @if($miembro->membresiaActiva)
                                        <span class="bg-green-500 text-white text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            Activa hasta {{ $miembro->membresiaActiva->fecha_fin->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="bg-gray-500 text-white text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            Sin membresía
                                        </span>
                                    @endif
                                </td>
                                <td class="border px-4 py-2">{{ $miembro->sucursal->nombre }}</td>
                                <td class="border px-4 py-2">
                                    <span class="{{ $miembro->activo ? 'bg-green-500' : 'bg-red-500' }} text-white text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        {{ $miembro->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="border px-4 py-2 whitespace-nowrap">
                                    <a href="{{ route('miembros.show', $miembro) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-1 px-2 rounded text-xs">Perfil</a>
                                    <button wire:click="edit({{ $miembro->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs ml-1">Editar</button>
                                    <button wire:click="openRenewalModal({{ $miembro->id }})" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs ml-1">Renovar</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="border px-4 py-2 text-center" colspan="7">No se encontraron miembros.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $miembros->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
