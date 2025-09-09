<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Sucursal;
use Livewire\WithPagination;

class SucursalManager extends Component
{
    use WithPagination;

    public $sucursal_id;
    public $nombre, $direccion, $telefono, $email, $capacidad_maxima, $horario_operacion, $activo;

    public $isModalOpen = false;
    public $isConfirmingDelete = false;
    public $sucursalToDeleteId;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'telefono' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'capacidad_maxima' => 'nullable|integer|min:1',
        'horario_operacion' => 'nullable|string',
        'activo' => 'boolean',
    ];

    public function render()
    {
        return view('livewire.admin.sucursal-manager', [
            'sucursales' => Sucursal::paginate(10),
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
        $this->sucursal_id = null;
        $this->nombre = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->email = '';
        $this->capacidad_maxima = '';
        $this->horario_operacion = '';
        $this->activo = true;
    }

    public function store()
    {
        $this->validate();

        Sucursal::updateOrCreate(['id' => $this->sucursal_id], [
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'capacidad_maxima' => $this->capacidad_maxima,
            'horario_operacion' => $this->horario_operacion,
            'activo' => $this->activo,
        ]);

        session()->flash('message', $this->sucursal_id ? 'Sucursal actualizada con éxito.' : 'Sucursal creada con éxito.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $this->sucursal_id = $id;
        $this->nombre = $sucursal->nombre;
        $this->direccion = $sucursal->direccion;
        $this->telefono = $sucursal->telefono;
        $this->email = $sucursal->email;
        $this->capacidad_maxima = $sucursal->capacidad_maxima;
        $this->horario_operacion = $sucursal->horario_operacion;
        $this->activo = $sucursal->activo;

        $this->openModal();
    }

    public function confirmDelete($id)
    {
        $this->sucursalToDeleteId = $id;
        $this->isConfirmingDelete = true;
    }

    public function delete()
    {
        Sucursal::find($this->sucursalToDeleteId)->delete();
        session()->flash('message', 'Sucursal eliminada con éxito.');
        $this->isConfirmingDelete = false;
    }
}
