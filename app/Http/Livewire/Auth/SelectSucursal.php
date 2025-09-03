<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelectSucursal extends Component
{
    public $sucursales;
    public $selectedSucursal;

    public function mount()
    {
        $user = Auth::user();
        $this->sucursales = $user->sucursales()->where('activa', true)->get();

        // If user only has access to one sucursal, select it automatically and redirect.
        if ($this->sucursales->count() === 1) {
            $this->setSelectedSucursal($this->sucursales->first()->id);
            return redirect()->intended(config('fortify.home'));
        }
    }

    public function submit()
    {
        $this->validate([
            'selectedSucursal' => 'required|exists:sucursales,id',
        ]);

        // Verify user has access to the selected sucursal
        $user = Auth::user();
        if ($user->sucursales()->where('id', $this->selectedSucursal)->exists()) {
            $this->setSelectedSucursal($this->selectedSucursal);
            return redirect()->intended(config('fortify.home'));
        }

        return back()->withErrors(['selectedSucursal' => 'No tienes acceso a esta sucursal.']);
    }

    private function setSelectedSucursal($sucursalId)
    {
        $sucursal = \App\Models\Sucursal::find($sucursalId);
        session([
            'selected_sucursal_id' => $sucursal->id,
            'selected_sucursal_nombre' => $sucursal->nombre,
        ]);
    }

    public function render()
    {
        return view('livewire.auth.select-sucursal')
            ->layout('layouts.guest');
    }
}
