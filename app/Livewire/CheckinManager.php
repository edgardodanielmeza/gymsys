<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Miembro;
use App\Models\Asistencia;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckinManager extends Component
{
    public $search = '';
    public $miembro;
    public $message = '';
    public $messageType = '';

    public function render()
    {
        return view('livewire.checkin-manager')->layout('layouts.app');
    }

    public function buscarMiembro()
    {
        $this->validate([
            'search' => 'required|string',
        ]);

        $this->resetMessages();
        $this->miembro = Miembro::with('membresiaActiva')->where('documento_identidad', $this->search)->first();

        if (!$this->miembro) {
            $this->message = 'No se encontró ningún miembro con ese documento de identidad.';
            $this->messageType = 'error';
        }
    }

    public function registrarEntrada()
    {
        if (!$this->miembro) {
            return;
        }

        // Doble verificación del estado de la membresía
        if (!$this->miembro->membresiaActiva || $this->miembro->membresiaActiva->fecha_fin < Carbon::today()) {
            $this->message = 'La membresía de este miembro no está activa.';
            $this->messageType = 'error';
            return;
        }

        // Verificar si ya registró entrada hoy en esta sucursal
        $sucursalId = session('selected_sucursal_id', Auth::user()->sucursal_id);
        $yaRegistrado = Asistencia::where('miembro_id', $this->miembro->id)
            ->where('sucursal_id', $sucursalId)
            ->whereDate('fecha_hora_entrada', Carbon::today())
            ->exists();

        if ($yaRegistrado) {
            $this->message = 'Este miembro ya ha registrado su entrada en esta sucursal hoy.';
            $this->messageType = 'warning';
            return;
        }

        Asistencia::create([
            'miembro_id' => $this->miembro->id,
            'sucursal_id' => $sucursalId,
            'user_id' => Auth::id(),
        ]);

        $this->message = '¡Entrada registrada con éxito para ' . $this->miembro->fullName . '!';
        $this->messageType = 'success';
        $this->miembro = null;
        $this->search = '';
    }

    private function resetMessages()
    {
        $this->message = '';
        $this->messageType = '';
    }
}
