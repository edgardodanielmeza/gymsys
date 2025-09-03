<?php

namespace App\Livewire\Auth;

use App\Models\Sucursal;
use Illuminate\Support\Collection;
use Livewire\Component;

class SeleccionarSucursal extends Component
{
    public Collection $sucursales;
    public ?int $sucursal_id = null;

    public function mount(): void
    {
        $this->sucursales = Sucursal::where('is_active', true)->get();
        // Pre-seleccionar la última sucursal usada por el usuario, si existe
        $this->sucursal_id = auth()->user()->last_sucursal_id;
    }

    public function seleccionar()
    {
        $this->validate([
            'sucursal_id' => 'required|exists:sucursales,id',
        ]);

        // Guardar la sucursal en la sesión
        session(['sucursal_id' => $this->sucursal_id]);

        // Actualizar la última sucursal usada por el usuario para futuras sesiones
        $user = auth()->user();
        if ($user->last_sucursal_id !== $this->sucursal_id) {
            $user->update(['last_sucursal_id' => $this->sucursal_id]);
        }

        return $this->redirect(route('dashboard'), navigate: true);
    }


    public function render()
    {
        return view('livewire.auth.seleccionar-sucursal')->layout('layouts.guest');
    }
}
