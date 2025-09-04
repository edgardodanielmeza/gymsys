<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\Sucursal;
use Illuminate\Support\Facades\Auth;

class SelectBranch extends Component
{
    public $sucursales;
    public $selected_sucursal_id;

    protected $rules = [
        'selected_sucursal_id' => 'required|exists:sucursales,id',
    ];

    public function mount()
    {
        $this->sucursales = Sucursal::where('activo', true)->get();
        // Pre-seleccionar la sucursal principal del usuario si la tiene
        $this->selected_sucursal_id = Auth::user()->sucursal_id ?? null;
    }

    public function render()
    {
        return view('livewire.auth.select-branch')->layout('layouts.guest');
    }

    public function setBranch()
    {
        $this->validate();

        $sucursal = Sucursal::find($this->selected_sucursal_id);

        if ($sucursal) {
            session(['selected_sucursal_id' => $sucursal->id]);
            session(['selected_sucursal_nombre' => $sucursal->nombre]);

            return redirect()->intended(config('fortify.home'));
        }

        // Manejar el caso de que la sucursal no se encuentre
        session()->flash('error', 'La sucursal seleccionada no es válida.');
    }
}
