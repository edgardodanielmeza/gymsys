<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Miembro;
use App\Models\TipoMembresia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MiembroProfile extends Component
{
    public Miembro $miembro;
    public $miembroToRenew; // Para compatibilidad con el modal

    // Propiedades para el modal de renovación
    public $isRenewalModalOpen = false;
    public $renewal_tipo_membresia_id;
    public $renewal_monto_pago;

    protected $rules = [
        'renewal_tipo_membresia_id' => 'required|exists:tipos_membresia,id',
        'renewal_monto_pago' => 'required|numeric|min:0',
    ];

    public function mount(Miembro $miembro)
    {
        $this->miembro = $miembro->load(['membresiaActiva', 'membresias.tipoMembresia', 'membresias.pagos', 'sucursal']);
    }

    public function render()
    {
        return view('livewire.miembro-profile', [
            'tipos_membresia' => TipoMembresia::where('activo', true)->get(),
        ])->layout('layouts.app');
    }

    public function openRenewalModal()
    {
        $this->miembroToRenew = $this->miembro; // Asignar el miembro actual al que se va a renovar
        $this->renewal_tipo_membresia_id = null;
        $this->renewal_monto_pago = null;
        $this->isRenewalModalOpen = true;
    }

    public function closeRenewalModal()
    {
        $this->isRenewalModalOpen = false;
        $this->miembroToRenew = null;
    }

    public function renewMembership()
    {
        $this->validate();

        DB::transaction(function () {
            $tipoMembresia = TipoMembresia::find($this->renewal_tipo_membresia_id);

            $ultimaMembresia = $this->miembroToRenew->membresias()->latest('fecha_fin')->first();
            $fechaInicio = Carbon::today();

            if ($ultimaMembresia && $ultimaMembresia->fecha_fin->isFuture()) {
                $fechaInicio = $ultimaMembresia->fecha_fin->addDay();
            }

            $fechaFin = $fechaInicio->copy()->addDays($tipoMembresia->duracion_en_dias);

            $membresia = $this->miembroToRenew->membresias()->create([
                'tipo_membresia_id' => $this->renewal_tipo_membresia_id,
                'sucursal_id' => session('selected_sucursal_id', Auth::user()->sucursal_id),
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'estado' => 'activa',
                'monto_pagado' => $this->renewal_monto_pago,
            ]);

            $membresia->pagos()->create([
                'user_id' => Auth::id(),
                'monto' => $this->renewal_monto_pago,
                'metodo_pago' => 'efectivo',
                'fecha_pago' => Carbon::now(),
            ]);
        });

        session()->flash('message', 'Membresía renovada con éxito.');
        $this->closeRenewalModal();
        // Recargar los datos del miembro para reflejar la nueva membresía
        $this->miembro->load(['membresiaActiva', 'membresias.tipoMembresia', 'membresias.pagos', 'sucursal']);
    }
}
