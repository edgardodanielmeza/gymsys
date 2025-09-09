<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    use HasFactory;

    protected $fillable = [
        'miembro_id',
        'tipo_membresia_id',
        'sucursal_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'monto_pagado',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'monto_pagado' => 'decimal:2',
    ];

    /**
     * Get the miembro that owns the Membresia.
     */
    public function miembro()
    {
        return $this->belongsTo(Miembro::class);
    }

    /**
     * Get the tipoMembresia that owns the Membresia.
     */
    public function tipoMembresia()
    {
        return $this->belongsTo(TipoMembresia::class);
    }

    /**
     * Get the sucursal where the transaction was made.
     */
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    /**
     * Get all of the pagos for the Membresia.
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
