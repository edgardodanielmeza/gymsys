<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Control de Asistencia (Check-in)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                {{-- Formulario de Búsqueda --}}
                <form wire:submit.prevent="buscarMiembro">
                    <div class="flex items-center">
                        <input wire:model.defer="search" type="text" class="block w-full rounded-md shadow-sm" placeholder="Ingresa el documento de identidad del miembro..." autofocus>
                        <button type="submit" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Buscar
                        </button>
                    </div>
                    @error('search') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </form>

                {{-- Mensajes de estado --}}
                @if ($message)
                    <div class="mt-4 p-4 rounded-md
                        @if($messageType === 'success') bg-green-100 text-green-800 @endif
                        @if($messageType === 'error') bg-red-100 text-red-800 @endif
                        @if($messageType === 'warning') bg-yellow-100 text-yellow-800 @endif
                    ">
                        {{ $message }}
                    </div>
                @endif

                {{-- Resultado de la Búsqueda --}}
                @if ($miembro)
                <div class="mt-6 border-t dark:border-gray-700 pt-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img src="{{ $miembro->foto_path ? asset('storage/' . $miembro->foto_path) : asset('img/default-avatar.png') }}" alt="Foto" class="h-24 w-24 rounded-full object-cover">
                        </div>
                        <div class="ml-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $miembro->fullName }}</h3>
                            <div class="mt-2">
                                @if ($miembro->membresiaActiva && $miembro->membresiaActiva->fecha_fin >= \Carbon\Carbon::today())
                                    <p class="text-lg">
                                        <span class="font-bold text-green-500">Membresía Activa</span>
                                        <span>- vence el {{ $miembro->membresiaActiva->fecha_fin->format('d/m/Y') }}</span>
                                    </p>
                                    <button wire:click="registrarEntrada" class="mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg text-lg">
                                        Registrar Entrada
                                    </button>
                                @else
                                    <p class="text-lg">
                                        <span class="font-bold text-red-500">Membresía Vencida o Inactiva</span>
                                    </p>
                                    <a href="{{ route('miembros.show', $miembro) }}" class="mt-4 inline-block bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                        Ver Perfil para Renovar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
