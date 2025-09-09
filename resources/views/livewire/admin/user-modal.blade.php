<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form>
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                        {{ $user_id ? 'Editar Usuario' : 'Crear Usuario' }}
                    </h3>
                    <div class="mt-4">
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-bold">Nombre</label>
                            <input type="text" id="name" wire:model.defer="name" class="mt-1 block w-full rounded-md shadow-sm">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-bold">Email</label>
                            <input type="email" id="email" wire:model.defer="email" class="mt-1 block w-full rounded-md shadow-sm">
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-bold">Contraseña</label>
                            <input type="password" id="password" wire:model.defer="password" class="mt-1 block w-full rounded-md shadow-sm" autocomplete="new-password">
                            @if ($user_id) <small class="text-gray-500">Dejar en blanco para no cambiar la contraseña.</small> @endif
                            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-bold">Confirmar Contraseña</label>
                            <input type="password" id="password_confirmation" wire:model.defer="password_confirmation" class="mt-1 block w-full rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label for="selected_role" class="block text-sm font-bold">Rol</label>
                            <select id="selected_role" wire:model.defer="selected_role" class="mt-1 block w-full rounded-md shadow-sm">
                                <option value="">Seleccione un rol</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('selected_role') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="sucursal_id_user" class="block text-sm font-bold">Sucursal Principal</label>
                            <select id="sucursal_id_user" wire:model.defer="sucursal_id_user" class="mt-1 block w-full rounded-md shadow-sm">
                                <option value="">Seleccione una sucursal</option>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                @endforeach
                            </select>
                            @error('sucursal_id_user') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>
                         <div class="mb-4">
                            <label for="activo" class="block text-gray-700 dark:text-gray-300 text-sm font-bold">Estado</label>
                            <select id="activo" wire:model.defer="activo" class="mt-1 block w-full rounded-md shadow-sm">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Guardar
                    </button>
                    <button wire:click="closeModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
