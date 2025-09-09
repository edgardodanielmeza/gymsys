<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pago;
use Livewire\WithPagination;
use Carbon\Carbon;

class PagoManager extends Component
{
    use WithPagination;

    public $search = '';
    public $fecha_inicio;
    public $fecha_fin;

    public function mount()
    {
        // Inicializar con el mes actual
        $this->fecha_inicio = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        $query = Pago::with(['membresia.miembro', 'usuario', 'membresia.sucursal'])
            ->whereBetween('fecha_pago', [$this->fecha_inicio, Carbon::parse($this->fecha_fin)->endOfDay()]);

        if (!empty($this->search)) {
            $query->whereHas('membresia.miembro', function ($q) {
                $q->where('nombres', 'like', '%' . $this->search . '%')
                  ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                  ->orWhere('documento_identidad', 'like', '%' . $this->search . '%');
            });
        }

        $pagos = $query->latest('fecha_pago')->paginate(15);

        $total = $query->sum('monto');

        return view('livewire.admin.pago-manager', [
            'pagos' => $pagos,
            'total_filtrado' => $total,
        ])->layout('layouts.app');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function filter()
    {
        // Este método se llama desde el botón de filtrar.
        // La propiedad `render` ya se encarga de la lógica al estar bindeada.
        // Solo necesitamos resetear la página para que la paginación comience desde 1.
        $this->resetPage();
    }
}
