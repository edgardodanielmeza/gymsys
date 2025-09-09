<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Caja;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CajaManager extends Component
{
    public $cajaAbierta;
    public $monto_inicial;

    // Para el cierre
    public $monto_final_real;
    public $notas_cierre;
    public $total_ventas_efectivo;

    public function mount()
    {
        $this->verificarCajaAbierta();
    }

    public function render()
    {
        return view('livewire.admin.caja-manager')->layout('layouts.app');
    }

    private function verificarCajaAbierta()
    {
        $this->cajaAbierta = Caja::where('user_id', Auth::id())
            ->where('estado', 'abierta')
            ->where('sucursal_id', session('selected_sucursal_id'))
            ->first();

        if ($this->cajaAbierta) {
            $this->total_ventas_efectivo = Venta::where('caja_id', $this->cajaAbierta->id)
                ->where('metodo_pago', 'efectivo')
                ->sum('total');
        }
    }

    public function abrirCaja()
    {
        $this->validate(['monto_inicial' => 'required|numeric|min:0']);

        // Verificar que no haya otra caja abierta para este usuario en esta sucursal
        if ($this->cajaAbierta) {
            session()->flash('error', 'Ya tienes una caja abierta en esta sucursal.');
            return;
        }

        Caja::create([
            'user_id' => Auth::id(),
            'sucursal_id' => session('selected_sucursal_id'),
            'monto_inicial' => $this->monto_inicial,
            'estado' => 'abierta',
        ]);

        $this->verificarCajaAbierta();
        $this->monto_inicial = '';
        session()->flash('message', 'Caja abierta con éxito.');
    }

    public function cerrarCaja()
    {
        $this->validate([
            'monto_final_real' => 'required|numeric|min:0',
            'notas_cierre' => 'nullable|string',
        ]);

        if (!$this->cajaAbierta) {
            session()->flash('error', 'No hay ninguna caja abierta para cerrar.');
            return;
        }

        $monto_final_calculado = $this->cajaAbierta->monto_inicial + $this->total_ventas_efectivo;
        $diferencia = $this->monto_final_real - $monto_final_calculado;

        $this->cajaAbierta->update([
            'monto_final_calculado' => $monto_final_calculado,
            'monto_final_real' => $this->monto_final_real,
            'diferencia' => $diferencia,
            'notas' => $this->notas_cierre,
            'estado' => 'cerrada',
            'fecha_cierre' => Carbon::now(),
        ]);

        $this->cajaAbierta = null;
        $this->monto_final_real = '';
        $this->notas_cierre = '';
        session()->flash('message', 'Caja cerrada con éxito.');
    }
}
