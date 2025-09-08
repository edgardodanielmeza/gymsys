<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <form wire:submit.prevent="store">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                        {{ $miembro_id ? 'Editar Miembro' : 'Registrar Nuevo Miembro' }}
                    </h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Columna 1: Datos Personales --}}
                        <div class="col-span-1">
                            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-300 pb-2 mb-3">Datos Personales</h4>
                            <div class="mb-4">
                                <label for="documento_identidad" class="block text-sm font-bold">Documento</label>
                                <input type="text" id="documento_identidad" wire:model.defer="documento_identidad" class="mt-1 block w-full rounded-md shadow-sm">
                                @error('documento_identidad') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="nombres" class="block text-sm font-bold">Nombres</label>
                                <input type="text" id="nombres" wire:model.defer="nombres" class="mt-1 block w-full rounded-md shadow-sm">
                                @error('nombres') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="apellidos" class="block text-sm font-bold">Apellidos</label>
                                <input type="text" id="apellidos" wire:model.defer="apellidos" class="mt-1 block w-full rounded-md shadow-sm">
                                @error('apellidos') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="fecha_nacimiento" class="block text-sm font-bold">Fecha de Nacimiento</label>
                                <input type="date" id="fecha_nacimiento" wire:model.defer="fecha_nacimiento" class="mt-1 block w-full rounded-md shadow-sm">
                                @error('fecha_nacimiento') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="telefono" class="block text-sm font-bold">Teléfono</label>
                                <input type="text" id="telefono" wire:model.defer="telefono" class="mt-1 block w-full rounded-md shadow-sm">
                                @error('telefono') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                             <div class="mb-4">
                                <label for="email" class="block text-sm font-bold">Email</label>
                                <input type="email" id="email" wire:model.defer="email" class="mt-1 block w-full rounded-md shadow-sm">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="direccion" class="block text-sm font-bold">Dirección</label>
                                <input type="text" id="direccion" wire:model.defer="direccion" class="mt-1 block w-full rounded-md shadow-sm">
                                @error('direccion') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Columna 2: Datos de Membresía y Sistema --}}
                        <div class="col-span-1">
                            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-300 pb-2 mb-3">Datos del Sistema</h4>
                            <div class="mb-4">
                                <label for="sucursal_id_miembro" class="block text-sm font-bold">Sucursal Principal</label>
                                <select id="sucursal_id_miembro" wire:model.defer="sucursal_id_miembro" class="mt-1 block w-full rounded-md shadow-sm">
                                    <option value="">Seleccione una sucursal</option>
                                    @foreach($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('sucursal_id_miembro') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="foto" class="block text-sm font-bold">Foto de Perfil</label>
                                <input type="file" id="foto" wire:model="foto" class="mt-1 block w-full text-sm">
                                @error('foto') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                <div wire:loading wire:target="foto" class="text-sm text-gray-500">Cargando...</div>
                                @if ($foto)
                                    <img src="{{ $foto->temporaryUrl() }}" class="mt-2 h-24 w-24 object-cover rounded-full">
                                @elseif ($existing_foto_path)
                                    <img src="{{ asset('storage/' . $existing_foto_path) }}" class="mt-2 h-24 w-24 object-cover rounded-full">
                                @endif
                            </div>

                            {{-- Sección para NUEVOS miembros --}}
                            @if(!$miembro_id)
                            <div class="mt-6 border-t border-gray-300 pt-4">
                                <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 pb-2 mb-3">Inscripción de Nueva Membresía</h4>
                                <div class="mb-4">
                                    <label for="tipo_membresia_id" class="block text-sm font-bold">Tipo de Membresía</label>
                                    <select id="tipo_membresia_id" wire:model="tipo_membresia_id" class="mt-1 block w-full rounded-md shadow-sm">
                                        <option value="">Seleccione un tipo</option>
                                        @foreach($tipos_membresia as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }} (${{ number_format($tipo->precio, 2) }})</option>
                                        @endforeach
                                    </select>
                                    @error('tipo_membresia_id') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-4">
                                    <label for="monto_pago" class="block text-sm font-bold">Monto a Pagar</label>
                                    <input type="number" step="0.01" id="monto_pago" wire:model="monto_pago" class="mt-1 block w-full rounded-md shadow-sm bg-gray-100 dark:bg-gray-700" readonly>
                                    @error('monto_pago') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
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
