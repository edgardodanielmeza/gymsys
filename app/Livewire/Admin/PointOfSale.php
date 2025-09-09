<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Miembro;
use App\Models\Caja;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PointOfSale extends Component
{
    public $cajaAbierta;

    // Carrito
    public $cart = [];
    public $total = 0;

    // Búsqueda
    public $search_producto = '';
    public $search_miembro = '';

    // Venta
    public $miembro_seleccionado_id;
    public $miembro_seleccionado_nombre;
    public $metodo_pago = 'efectivo';

    public function mount()
    {
        $this->cajaAbierta = Caja::where('user_id', Auth::id())
            ->where('estado', 'abierta')
            ->where('sucursal_id', session('selected_sucursal_id'))
            ->first();
    }

    public function render()
    {
        $productos = [];
        if (strlen($this->search_producto) >= 2) {
            $productos = Producto::where('nombre', 'like', '%' . $this->search_producto . '%')
                ->orWhere('sku', 'like', '%' . $this->search_producto . '%')
                ->where('stock', '>', 0)
                ->take(5)
                ->get();
        }

        $miembros = [];
        if (strlen($this->search_miembro) >= 2) {
            $miembros = Miembro::where('nombres', 'like', '%' . $this->search_miembro . '%')
                ->orWhere('apellidos', 'like', '%' . $this->search_miembro . '%')
                ->orWhere('documento_identidad', 'like', '%' . $this->search_miembro . '%')
                ->take(5)
                ->get();
        }

        return view('livewire.admin.point-of-sale', [
            'productos' => $productos,
            'miembros' => $miembros,
        ])->layout('layouts.app');
    }

    public function addToCart(Producto $producto)
    {
        if ($producto->stock <= 0) {
            session()->flash('error', 'Producto sin stock.');
            return;
        }

        if (isset($this->cart[$producto->id])) {
            if ($this->cart[$producto->id]['cantidad'] < $producto->stock) {
                $this->cart[$producto->id]['cantidad']++;
            }
        } else {
            $this->cart[$producto->id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
            ];
        }
        $this->search_producto = '';
        $this->calculateTotal();
    }

    public function removeFromCart($productoId)
    {
        unset($this->cart[$productoId]);
        $this->calculateTotal();
    }

    public function updateCartQuantity($productoId, $cantidad)
    {
        $producto = Producto::find($productoId);
        if ($cantidad > 0 && $cantidad <= $producto->stock) {
            $this->cart[$productoId]['cantidad'] = $cantidad;
        } else {
            $this->cart[$productoId]['cantidad'] = 1;
        }
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = collect($this->cart)->sum(function ($item) {
            return $item['precio'] * $item['cantidad'];
        });
    }

    public function selectMiembro(Miembro $miembro)
    {
        $this->miembro_seleccionado_id = $miembro->id;
        $this->miembro_seleccionado_nombre = $miembro->fullName;
        $this->search_miembro = '';
    }

    public function clearMiembro()
    {
        $this->miembro_seleccionado_id = null;
        $this->miembro_seleccionado_nombre = null;
    }

    public function finalizeSale()
    {
        if (empty($this->cart) || !$this->cajaAbierta) {
            return;
        }

        $this->validate(['metodo_pago' => 'required']);

        DB::transaction(function () {
            $venta = Venta::create([
                'caja_id' => $this->cajaAbierta->id,
                'miembro_id' => $this->miembro_seleccionado_id,
                'user_id' => Auth::id(),
                'total' => $this->total,
                'metodo_pago' => $this->metodo_pago,
            ]);

            foreach ($this->cart as $item) {
                $venta->items()->create([
                    'producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'precio_total' => $item['precio'] * $item['cantidad'],
                ]);

                // Decrementar stock
                $producto = Producto::find($item['id']);
                $producto->decrement('stock', $item['cantidad']);
            }
        });

        session()->flash('message', 'Venta registrada con éxito.');
        $this->resetCartAndCustomer();
    }

    private function resetCartAndCustomer()
    {
        $this->cart = [];
        $this->total = 0;
        $this->clearMiembro();
    }
}
