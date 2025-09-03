<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Sucursales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between">
                        <h1 class="text-2xl font-medium text-gray-900 dark:text-white">
                            Listado de Sucursales
                        </h1>
                        <x-button wire:click="addNew">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            {{ __('Nueva Sucursal') }}
                        </x-button>
                    </div>

                    <div class="mt-6 text-gray-500 dark:text-gray-400">
                        <!-- Search and Table -->
                        <div class="mb-4">
                            <x-input wire:model.live.debounce.300ms="search" type="text" class="w-full" placeholder="Buscar sucursal por nombre..." />
                        </div>

                        <div class="shadow-sm overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        <th class="px-5 py-3">{{ __('Nombre') }}</th>
                                        <th class="px-5 py-3">{{ __('Teléfono') }}</th>
                                        <th class="px-5 py-3">{{ __('Estado') }}</th>
                                        <th class="px-5 py-3">{{ __('Acciones') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($sucursales as $sucursal)
                                        <tr class="text-gray-700 dark:text-gray-400">
                                            <td class="px-5 py-5">{{ $sucursal->nombre }}</td>
                                            <td class="px-5 py-5">{{ $sucursal->telefono }}</td>
                                            <td class="px-5 py-5">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $sucursal->activa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $sucursal->activa ? 'Activa' : 'Inactiva' }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-5">
                                                <x-secondary-button wire:click="edit({{ $sucursal->id }})">{{ __('Editar') }}</x-secondary-button>
                                                <x-danger-button wire:click="confirmDelete({{ $sucursal->id }})">{{ __('Eliminar') }}</x-danger-button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-5 py-5 text-center">{{ __('No se encontraron sucursales.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $sucursales->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit/Create Modal -->
    <x-dialog-modal wire:model.live="showEditModal">
        <x-slot name="title">
            {{ isset($this->sucursal->id) ? 'Editar Sucursal' : 'Crear Nueva Sucursal' }}
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <x-label for="nombre" value="{{ __('Nombre') }}" />
                    <x-input id="nombre" type="text" class="mt-1 block w-full" wire:model.defer="state.nombre" />
                    <x-input-error for="state.nombre" class="mt-2" />
                </div>
                <div class="col-span-2">
                    <x-label for="direccion" value="{{ __('Dirección') }}" />
                    <x-input id="direccion" type="text" class="mt-1 block w-full" wire:model.defer="state.direccion" />
                    <x-input-error for="state.direccion" class="mt-2" />
                </div>
                <div>
                    <x-label for="telefono" value="{{ __('Teléfono') }}" />
                    <x-input id="telefono" type="text" class="mt-1 block w-full" wire:model.defer="state.telefono" />
                    <x-input-error for="state.telefono" class="mt-2" />
                </div>
                <div>
                    <x-label for="email" value="{{ __('Email (Opcional)') }}" />
                    <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
                    <x-input-error for="state.email" class="mt-2" />
                </div>
                <div>
                    <x-label for="capacidad_maxima" value="{{ __('Capacidad Máxima') }}" />
                    <x-input id="capacidad_maxima" type="number" class="mt-1 block w-full" wire:model.defer="state.capacidad_maxima" />
                    <x-input-error for="state.capacidad_maxima" class="mt-2" />
                </div>
                <div class="col-span-2">
                    <x-label for="horario_operacion" value="{{ __('Horario de Operación') }}" />
                    <textarea id="horario_operacion" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" wire:model.defer="state.horario_operacion"></textarea>
                    <x-input-error for="state.horario_operacion" class="mt-2" />
                </div>
                <div class="col-span-2">
                    <label class="flex items-center">
                        <x-checkbox wire:model.defer="state.activa" />
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Sucursal Activa') }}</span>
                    </label>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showEditModal', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-button class="ml-3" wire:click="save" wire:loading.attr="disabled">
                {{ __('Guardar') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Delete Confirmation Modal -->
    <x-confirmation-modal wire:model.live="showDeleteModal">
        <x-slot name="title">
            {{ __('Eliminar Sucursal') }}
        </x-slot>

        <x-slot name="content">
            {{ __('¿Estás seguro de que deseas eliminar esta sucursal? Esta acción no se puede deshacer.') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showDeleteModal', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Eliminar') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
