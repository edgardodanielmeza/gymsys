<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Producto;
use App\Models\CategoriaProducto;
use Livewire\WithPagination;

class ProductManager extends Component
{
    use WithPagination;

    // Propiedades para Productos
    public $producto_id, $nombre_producto, $descripcion_producto, $precio, $costo, $stock, $sku, $categoria_id;

    // Propiedades para Categorías
    public $categoria_id_edit, $nombre_categoria, $descripcion_categoria;

    // Control UI
    public $isProductModalOpen = false;
    public $isCategoryModalOpen = false;
    public $search = '';

    public function render()
    {
        $productos = Producto::with('categoria')
            ->where('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('sku', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.admin.product-manager', [
            'productos' => $productos,
            'categorias' => CategoriaProducto::all(),
        ])->layout('layouts.app');
    }

    // --- Lógica de Productos ---

    public function openProductModal() { $this->isProductModalOpen = true; }
    public function closeProductModal() { $this->isProductModalOpen = false; }

    public function createProduct()
    {
        $this->resetProductInput();
        $this->openProductModal();
    }

    public function storeProduct()
    {
        $this->validate([
            'nombre_producto' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'costo' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:productos,sku,' . $this->producto_id,
            'categoria_id' => 'nullable|exists:categorias_producto,id',
        ]);

        Producto::updateOrCreate(['id' => $this->producto_id], [
            'nombre' => $this->nombre_producto,
            'descripcion' => $this->descripcion_producto,
            'precio' => $this->precio,
            'costo' => $this->costo,
            'stock' => $this->stock,
            'sku' => $this->sku,
            'categoria_id' => $this->categoria_id,
        ]);

        session()->flash('message', $this->producto_id ? 'Producto actualizado.' : 'Producto creado.');
        $this->closeProductModal();
        $this->resetProductInput();
    }

    public function editProduct($id)
    {
        $producto = Producto::findOrFail($id);
        $this->producto_id = $id;
        $this->nombre_producto = $producto->nombre;
        $this->descripcion_producto = $producto->descripcion;
        $this->precio = $producto->precio;
        $this->costo = $producto->costo;
        $this->stock = $producto->stock;
        $this->sku = $producto->sku;
        $this->categoria_id = $producto->categoria_id;
        $this->openProductModal();
    }

    private function resetProductInput()
    {
        $this->producto_id = null;
        $this->nombre_producto = '';
        $this->descripcion_producto = '';
        $this->precio = '';
        $this->costo = '';
        $this->stock = '';
        $this->sku = '';
        $this->categoria_id = null;
    }

    // --- Lógica de Categorías ---

    public function openCategoryModal() { $this->isCategoryModalOpen = true; }
    public function closeCategoryModal() { $this->isCategoryModalOpen = false; }

    public function createCategory()
    {
        $this->resetCategoryInput();
        $this->openCategoryModal();
    }

    public function storeCategory()
    {
        $this->validate([
            'nombre_categoria' => 'required|string|max:255|unique:categorias_producto,nombre,' . $this->categoria_id_edit,
        ]);

        CategoriaProducto::updateOrCreate(['id' => $this->categoria_id_edit], [
            'nombre' => $this->nombre_categoria,
            'descripcion' => $this->descripcion_categoria,
        ]);

        session()->flash('message', $this->categoria_id_edit ? 'Categoría actualizada.' : 'Categoría creada.');
        $this->closeCategoryModal();
        $this->resetCategoryInput();
    }

    public function editCategory($id)
    {
        $categoria = CategoriaProducto::findOrFail($id);
        $this->categoria_id_edit = $id;
        $this->nombre_categoria = $categoria->nombre;
        $this->descripcion_categoria = $categoria->descripcion;
        $this->openCategoryModal();
    }

    private function resetCategoryInput()
    {
        $this->categoria_id_edit = null;
        $this->nombre_categoria = '';
        $this->descripcion_categoria = '';
    }
}
