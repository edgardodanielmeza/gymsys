<div>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <x-authentication-card-logo />
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <h2 class="text-center text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                Seleccionar Sucursal
            </h2>
            <p class="text-center text-sm text-gray-600 dark:text-gray-400 mb-6">
                Por favor, elige la sucursal en la que vas a trabajar hoy.
            </p>

            @if (session()->has('error'))
                <div class="mb-4 font-medium text-sm text-red-600">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="setBranch">
                <div>
                    <x-label for="sucursal" value="{{ __('Sucursal') }}" />
                    <select id="sucursal" wire:model="selected_sucursal_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="">-- Elige una sucursal --</option>
                        @foreach($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                        @endforeach
                    </select>
                    @error('selected_sucursal_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ml-4">
                        {{ __('Continuar') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
