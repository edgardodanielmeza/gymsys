<div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form wire:submit.prevent="renewMembership">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                        Renovar Membresía
                    </h3>

                    @if($miembroToRenew)
                    <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200">Miembro: {{ $miembroToRenew->fullName }}</p>
                        @if($miembroToRenew->membresiaActiva)
                            <p class="text-sm text-gray-600 dark:text-gray-400">Membresía actual vence: {{ $miembroToRenew->membresiaActiva->fecha_fin->format('d/m/Y') }}</p>
                        @else
                            <p class="text-sm text-gray-600 dark:text-gray-400">El miembro no tiene una membresía activa.</p>
                        @endif
                    </div>
                    @endif

                    <div class="mt-4">
                        <div class="mb-4">
                            <label for="renewal_tipo_membresia_id" class="block text-sm font-bold">Nuevo Tipo de Membresía</label>
                            <select id="renewal_tipo_membresia_id" wire:model="renewal_tipo_membresia_id" class="mt-1 block w-full rounded-md shadow-sm">
                                <option value="">Seleccione un tipo</option>
                                @foreach($tipos_membresia as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }} (${{ number_format($tipo->precio, 2) }})</option>
                                @endforeach
                            </select>
                            @error('renewal_tipo_membresia_id') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="renewal_monto_pago" class="block text-sm font-bold">Monto a Pagar</label>
                            <input type="number" step="0.01" id="renewal_monto_pago" wire:model="renewal_monto_pago" class="mt-1 block w-full rounded-md shadow-sm bg-gray-100 dark:bg-gray-700" readonly>
                            @error('renewal_monto_pago') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Confirmar Renovación
                    </button>
                    <button wire:click="closeRenewalModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
