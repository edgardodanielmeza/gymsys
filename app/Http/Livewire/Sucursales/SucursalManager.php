<?php

namespace App\Http\Livewire\Sucursales;

use Livewire\Component;
use App\Models\Sucursal;
use Livewire\WithPagination;

class SucursalManager extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';

    public $sucursal;
    public $state = [];
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $sucursalIdBeingDeleted = null;

    protected $rules = [
        'state.nombre' => 'required|string|max:100',
        'state.direccion' => 'required|string|max:255',
        'state.telefono' => 'required|string|max:20',
        'state.email' => 'nullable|email|max:255',
        'state.capacidad_maxima' => 'required|integer|min:0',
        'state.horario_operacion' => 'nullable|string',
        'state.activa' => 'boolean',
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function addNew()
    {
        $this->reset();
        $this->state['activa'] = true; // Default value
        $this->showEditModal = true;
    }

    public function edit(Sucursal $sucursal)
    {
        $this->sucursal = $sucursal;
        $this->state = $sucursal->toArray();
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        if (isset($this->sucursal->id)) {
            $this->sucursal->update($this->state);
            session()->flash('success', 'Sucursal actualizada con éxito.');
        } else {
            Sucursal::create($this->state);
            session()->flash('success', 'Sucursal creada con éxito.');
        }

        $this->showEditModal = false;
    }

    public function confirmDelete($sucursalId)
    {
        $this->sucursalIdBeingDeleted = $sucursalId;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Sucursal::findOrFail($this->sucursalIdBeingDeleted)->delete();
        session()->flash('success', 'Sucursal eliminada con éxito.');
        $this->showDeleteModal = false;
        $this->sucursalIdBeingDeleted = null;
    }

    public function render()
    {
        $sucursales = Sucursal::query()
            ->where('nombre', 'like', '%'.$this->search.'%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.sucursales.sucursal-manager', [
            'sucursales' => $sucursales,
        ])->layout('layouts.app');
    }
}
