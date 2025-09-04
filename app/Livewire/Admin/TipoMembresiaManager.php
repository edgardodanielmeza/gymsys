<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\TipoMembresia;
use Livewire\WithPagination;

class TipoMembresiaManager extends Component
{
    use WithPagination;

    public $tipo_membresia_id;
    public $nombre, $descripcion, $precio, $duracion_en_dias, $activo;

    public $isModalOpen = false;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'precio' => 'required|numeric|min:0',
        'duracion_en_dias' => 'required|integer|min:1',
        'activo' => 'boolean',
    ];

    public function render()
    {
        return view('livewire.admin.tipo-membresia-manager', [
            'tipos' => TipoMembresia::paginate(10),
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
        $this->tipo_membresia_id = null;
        $this->nombre = '';
        $this->descripcion = '';
        $this->precio = '';
        $this->duracion_en_dias = '';
        $this->activo = true;
    }

    public function store()
    {
        $this->validate();

        TipoMembresia::updateOrCreate(['id' => $this->tipo_membresia_id], [
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'duracion_en_dias' => $this->duracion_en_dias,
            'activo' => $this->activo,
        ]);

        session()->flash('message', $this->tipo_membresia_id ? 'Tipo de membresía actualizado.' : 'Tipo de membresía creado.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $tipo = TipoMembresia::findOrFail($id);
        $this->tipo_membresia_id = $id;
        $this->nombre = $tipo->nombre;
        $this->descripcion = $tipo->descripcion;
        $this->precio = $tipo->precio;
        $this->duracion_en_dias = $tipo->duracion_en_dias;
        $this->activo = $tipo->activo;

        $this->openModal();
    }
}
