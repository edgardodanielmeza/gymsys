<div>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl font-bold text-center text-gray-700 dark:text-white mb-4">
                Seleccionar Sucursal
            </h2>
            <p class="text-center text-sm text-gray-600 dark:text-gray-400 mb-6">
                Por favor, elige la sucursal en la que deseas trabajar hoy.
            </p>

            <form wire:submit.prevent="seleccionar">
                <div>
                    <label for="sucursal" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        Sucursal
                    </label>
                    <select id="sucursal" wire:model="sucursal_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="">-- Elige una sucursal --</option>
                        @foreach($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                        @endforeach
                    </select>
                    @error('sucursal_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-600 disabled:opacity-25 transition">
                        Continuar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
