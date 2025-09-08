<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Inventario y Productos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                    <div class="flex"><div><p class="text-sm">{{ session('message') }}</p></div></div>
                </div>
            @endif

            @if($isProductModalOpen)
                @include('livewire.admin.product-modal')
            @endif
            @if($isCategoryModalOpen)
                @include('livewire.admin.category-modal')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                {{-- Columna de Categorías --}}
                <div class="md:col-span-4">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Categorías</h3>
                            <button wire:click="createCategory()" class="bg-blue-500 text-white font-bold py-1 px-2 rounded text-xs">Añadir</button>
                        </div>
                        <ul>
                            @forelse($categorias as $categoria)
                                <li class="flex justify-between items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span>{{ $categoria->nombre }}</span>
                                    <button wire:click="editCategory({{ $categoria->id }})" class="text-yellow-500 text-xs">Editar</button>
                                </li>
                            @empty
                                <li class="text-gray-500 text-sm">No hay categorías.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                {{-- Columna de Productos --}}
                <div class="md:col-span-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <div class="w-1/2">
                                <input wire:model.live.debounce.300ms="search" type="text" class="shadow appearance-none border rounded w-full py-2 px-3" placeholder="Buscar productos...">
                            </div>
                            <button wire:click="createProduct()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Crear Nuevo Producto
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead>
                                    <tr class="bg-gray-100 dark:bg-gray-700">
                                        <th class="px-4 py-2 text-left">Nombre</th>
                                        <th class="px-4 py-2 text-left">Categoría</th>
                                        <th class="px-4 py-2 text-left">Precio</th>
                                        <th class="px-4 py-2 text-left">Stock</th>
                                        <th class="px-4 py-2 text-left">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productos as $producto)
                                    <tr class="text-gray-700 dark:text-gray-300">
                                        <td class="border px-4 py-2">{{ $producto->nombre }}</td>
                                        <td class="border px-4 py-2">{{ $producto->categoria->nombre ?? 'N/A' }}</td>
                                        <td class="border px-4 py-2">${{ number_format($producto->precio, 2) }}</td>
                                        <td class="border px-4 py-2 @if($producto->stock < 10) text-red-500 font-bold @endif">{{ $producto->stock }}</td>
                                        <td class="border px-4 py-2">
                                            <button wire:click="editProduct({{ $producto->id }})" class="bg-yellow-500 text-white font-bold py-1 px-2 rounded text-xs">Editar</button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td class="border px-4 py-2 text-center" colspan="5">No se encontraron productos.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $productos->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
