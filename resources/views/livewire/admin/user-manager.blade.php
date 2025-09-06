<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Usuarios del Sistema') }}
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
                        <input wire:model.live.debounce.300ms="search" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:bg-gray-900 dark:text-gray-300 leading-tight focus:outline-none focus:shadow-outline" placeholder="Buscar por nombre o email...">
                    </div>
                    <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Crear Nuevo Usuario
                    </button>
                </div>

                @if($isModalOpen)
                    @include('livewire.admin.user-modal')
                @endif

                <div class="overflow-x-auto">
                    <table class="table-auto w-full">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Nombre</th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Email</th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Rol</th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Sucursal Principal</th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Estado</th>
                                <th class="px-4 py-2 text-left text-gray-900 dark:text-white">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr class="text-gray-700 dark:text-gray-300">
                                <td class="border px-4 py-2">{{ $user->name }}</td>
                                <td class="border px-4 py-2">{{ $user->email }}</td>
                                <td class="border px-4 py-2">{{ $user->roles->first()->name ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">{{ $user->sucursal->nombre ?? 'N/A' }}</td>
                                <td class="border px-4 py-2">
                                    <span class="{{ $user->activo ? 'bg-green-500' : 'bg-red-500' }} text-white text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">
                                        {{ $user->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="border px-4 py-2">
                                    <button wire:click="edit({{ $user->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Editar</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="border px-4 py-2 text-center" colspan="6">No se encontraron usuarios.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
