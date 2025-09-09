<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Punto de Venta (POS)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($cajaAbierta)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                    {{-- Columna de Productos --}}
                    <div class="lg:col-span-7">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-4">
                            <input type="text" wire:model.live.debounce.300ms="search_producto" placeholder="Buscar producto por nombre o SKU..." class="w-full rounded-md shadow-sm">

                            @if(!empty($productos))
                            <ul class="mt-2 border dark:border-gray-700 rounded-md">
                                @foreach($productos as $producto)
                                <li wire:click="addToCart({{ $producto->id }})" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer border-b dark:border-gray-600">
                                    {{ $producto->nombre }} - {{ $appSettings['currency_symbol'] ?? '$' }}{{ number_format($producto->precio, 2) }} (Stock: {{ $producto->stock }})
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>

                    {{-- Columna de Carrito y Venta --}}
                    <div class="lg:col-span-5">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-4">
                            <h3 class="text-xl font-semibold mb-4">Carrito de Compras</h3>

                            @if(empty($cart))
                                <p class="text-gray-500">El carrito está vacío.</p>
                            @else
                                @foreach($cart as $item)
                                    <div class="flex justify-between items-center mb-2">
                                        <span>{{ $item['nombre'] }}</span>
                                        <div class="flex items-center">
                                            <input type="number" wire:change="updateCartQuantity({{ $item['id'] }}, $event.target.value)" value="{{ $item['cantidad'] }}" class="w-16 text-center rounded-md text-sm">
                                            <span class="ml-2 w-20 text-right">{{ $appSettings['currency_symbol'] ?? '$' }}{{ number_format($item['precio'] * $item['cantidad'], 2) }}</span>
                                            <button wire:click="removeFromCart({{ $item['id'] }})" class="ml-2 text-red-500">X</button>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="border-t dark:border-gray-700 mt-4 pt-4 text-right">
                                    <p class="text-2xl font-bold">Total: {{ $appSettings['currency_symbol'] ?? '$' }}{{ number_format($total, 2) }}</p>
                                </div>
                            @endif

                            <div class="border-t dark:border-gray-700 mt-6 pt-6">
                                <h3 class="text-lg font-semibold mb-2">Cliente</h3>
                                @if($miembro_seleccionado_nombre)
                                    <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 p-2 rounded">
                                        <span>{{ $miembro_seleccionado_nombre }}</span>
                                        <button wire:click="clearMiembro" class="text-red-500 text-sm">Quitar</button>
                                    </div>
                                @else
                                    <input type="text" wire:model.live.debounce.300ms="search_miembro" placeholder="Buscar miembro (opcional)..." class="w-full rounded-md shadow-sm">
                                    @if(!empty($miembros))
                                    <ul class="mt-2 border dark:border-gray-700 rounded-md">
                                        @foreach($miembros as $miembro)
                                        <li wire:click="selectMiembro({{ $miembro->id }})" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer border-b dark:border-gray-600">
                                            {{ $miembro->fullName }} ({{ $miembro->documento_identidad }})
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                @endif
                            </div>

                            <div class="border-t dark:border-gray-700 mt-6 pt-6">
                                <h3 class="text-lg font-semibold mb-2">Pago</h3>
                                <select wire:model="metodo_pago" class="w-full rounded-md shadow-sm">
                                    <option value="efectivo">Efectivo</option>
                                    <option value="tarjeta">Tarjeta</option>
                                    <option value="transferencia">Transferencia</option>
                                </select>
                            </div>

                            <div class="mt-6">
                                <button wire:click="finalizeSale" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded text-lg" @if(empty($cart)) disabled @endif>
                                    Finalizar Venta
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                {{-- Mensaje para abrir caja --}}
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                    <p class="font-bold">Caja Cerrada</p>
                    <p>Necesitas abrir una caja para poder registrar ventas. Ve a la sección de <a href="{{ route('admin.caja.manager') }}" class="underline">Gestión de Caja</a>.</p>
                </div>
            @endif

        </div>
    </div>
</div>
