<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Miembro;
use App\Models\TipoMembresia;
use App\Models\Membresia;
use App\Models\Pago;
use App\Models\Sucursal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class MiembroManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Propiedades del Miembro
    public $miembro_id;
    public $documento_identidad, $nombres, $apellidos, $fecha_nacimiento, $telefono, $email, $direccion, $sucursal_id_miembro, $activo = true;
    public $foto, $existing_foto_path;

    // Propiedades para la nueva membresía y pago
    public $tipo_membresia_id;
    public $monto_pago;

    // Control UI
    public $isModalOpen = false;
    public $isRenewalModalOpen = false;
    public $search = '';

    // Propiedades para la renovación
    public $miembroToRenew;
    public $renewal_tipo_membresia_id;
    public $renewal_monto_pago;

    protected function rules()
    {
        $rules = [
            'documento_identidad' => 'required|string|unique:miembros,documento_identidad,' . $this->miembro_id,
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:miembros,email,' . $this->miembro_id,
            'direccion' => 'nullable|string',
            'sucursal_id_miembro' => 'required|exists:sucursales,id',
            'activo' => 'boolean',
            'foto' => 'nullable|image|max:1024', // 1MB Max
        ];

        if ($this->isModalOpen && !$this->miembro_id) {
            $rules['tipo_membresia_id'] = 'required|exists:tipos_membresia,id';
            $rules['monto_pago'] = 'required|numeric|min:0';
        }

        if ($this->isRenewalModalOpen) {
            $rules['renewal_tipo_membresia_id'] = 'required|exists:tipos_membresia,id';
            $rules['renewal_monto_pago'] = 'required|numeric|min:0';
        }

        return $rules;
    }

    public function render()
    {
        $miembros = Miembro::with('sucursal', 'membresiaActiva')
            ->where(function($query) {
                $query->where('nombres', 'like', '%'.$this->search.'%')
                      ->orWhere('apellidos', 'like', '%'.$this->search.'%')
                      ->orWhere('documento_identidad', 'like', '%'.$this->search.'%');
            })
            ->paginate(10);

        return view('livewire.miembro-manager', [
            'miembros' => $miembros,
            'tipos_membresia' => TipoMembresia::where('activo', true)->get(),
            'sucursales' => Sucursal::where('activo', true)->get(),
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->miembro_id = null;
        $this->documento_identidad = '';
        $this->nombres = '';
        $this->apellidos = '';
        $this->fecha_nacimiento = '';
        $this->telefono = '';
        $this->email = '';
        $this->direccion = '';
        $this->sucursal_id_miembro = '';
        $this->activo = true;
        $this->foto = null;
        $this->existing_foto_path = null;
        $this->tipo_membresia_id = '';
        $this->monto_pago = '';
    }

    public function store()
    {
        $this->validate();

        DB::transaction(function () {
            // Guardar foto si existe
            $fotoPath = $this->existing_foto_path;
            if ($this->foto) {
                $fotoPath = $this->foto->store('fotos-miembros', 'public');
            }

            // Crear o actualizar el miembro
            $miembro = Miembro::updateOrCreate(['id' => $this->miembro_id], [
                'documento_identidad' => $this->documento_identidad,
                'nombres' => $this->nombres,
                'apellidos' => $this->apellidos,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'telefono' => $this->telefono,
                'email' => $this->email,
                'direccion' => $this->direccion,
                'sucursal_id' => $this->sucursal_id_miembro,
                'activo' => $this->activo,
                'foto_path' => $fotoPath,
            ]);

            // Si es un nuevo miembro, crear membresía y pago
            if (!$this->miembro_id && $this->tipo_membresia_id) {
                $tipoMembresia = TipoMembresia::find($this->tipo_membresia_id);
                $fechaInicio = Carbon::today();
                $fechaFin = $fechaInicio->copy()->addDays($tipoMembresia->duracion_en_dias);

                $membresia = $miembro->membresias()->create([
                    'tipo_membresia_id' => $this->tipo_membresia_id,
                    'sucursal_id' => session('selected_sucursal_id', $this->sucursal_id_miembro),
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin,
                    'estado' => 'activa',
                    'monto_pagado' => $this->monto_pago,
                ]);

                $membresia->pagos()->create([
                    'user_id' => Auth::id(),
                    'monto' => $this->monto_pago,
                    'metodo_pago' => 'efectivo', // Hardcoded por ahora
                    'fecha_pago' => Carbon::now(),
                ]);
            }
        });

        session()->flash('message', $this->miembro_id ? 'Miembro actualizado con éxito.' : 'Miembro, membresía y pago creados con éxito.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $miembro = Miembro::findOrFail($id);
        $this->miembro_id = $id;
        $this->documento_identidad = $miembro->documento_identidad;
        $this->nombres = $miembro->nombres;
        $this->apellidos = $miembro->apellidos;
        $this->fecha_nacimiento = $miembro->fecha_nacimiento->format('Y-m-d');
        $this->telefono = $miembro->telefono;
        $this->email = $miembro->email;
        $this->direccion = $miembro->direccion;
        $this->sucursal_id_miembro = $miembro->sucursal_id;
        $this->activo = $miembro->activo;
        $this->existing_foto_path = $miembro->foto_path;

        // No cargamos la membresía y pago para editar, solo datos del miembro
        $this->tipo_membresia_id = '';
        $this->monto_pago = '';

        $this->openModal();
    }

    public function openRenewalModal($miembroId)
    {
        $this->miembroToRenew = Miembro::with('membresiaActiva')->findOrFail($miembroId);
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
        $this->validate([
            'renewal_tipo_membresia_id' => 'required|exists:tipos_membresia,id',
            'renewal_monto_pago' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () {
            $tipoMembresia = TipoMembresia::find($this->renewal_tipo_membresia_id);

            // Lógica para determinar la fecha de inicio
            $ultimaMembresia = $this->miembroToRenew->membresias()->latest('fecha_fin')->first();
            $fechaInicio = Carbon::today();

            if ($ultimaMembresia && $ultimaMembresia->fecha_fin->isFuture()) {
                // Si la última membresía aún no ha vencido, la nueva comienza cuando la anterior termina.
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
                'metodo_pago' => 'efectivo', // Hardcoded por ahora
                'fecha_pago' => Carbon::now(),
            ]);
        });

        session()->flash('message', 'Membresía renovada con éxito.');
        $this->closeRenewalModal();
    }
}
