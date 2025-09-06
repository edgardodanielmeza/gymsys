<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Configuración General') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if (session()->has('message'))
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                        <div class="flex"><div><p class="text-sm">{{ session('message') }}</p></div></div>
                    </div>
                @endif

                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nombre del Gimnasio --}}
                        <div class="md:col-span-1">
                            <label for="gym_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Gimnasio</label>
                            <input type="text" id="gym_name" wire:model.defer="gym_name" class="mt-1 block w-full rounded-md shadow-sm">
                            @error('gym_name') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>

                        {{-- Símbolo de Moneda --}}
                        <div class="md:col-span-1">
                            <label for="currency_symbol" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Símbolo de Moneda</label>
                            <input type="text" id="currency_symbol" wire:model.defer="currency_symbol" class="mt-1 block w-full rounded-md shadow-sm">
                            @error('currency_symbol') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>

                        {{-- Logo --}}
                        <div class="md:col-span-2">
                            <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Logo del Gimnasio</label>
                            <input type="file" id="logo" wire:model="logo" class="mt-1 block w-full text-sm">
                            @error('logo') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror

                            <div wire:loading wire:target="logo" class="text-sm text-gray-500 mt-2">Cargando...</div>

                            <div class="mt-4">
                                @if ($logo)
                                    <p class="text-sm mb-2">Previsualización:</p>
                                    <img src="{{ $logo->temporaryUrl() }}" class="h-20">
                                @elseif ($existing_logo_path)
                                    <p class="text-sm mb-2">Logo Actual:</p>
                                    <img src="{{ asset('storage/' . $existing_logo_path) }}" class="h-20">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 text-right">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Guardar Configuración
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
