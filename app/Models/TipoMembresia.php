<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMembresia extends Model
{
    use HasFactory;

    protected $table = 'tipos_membresia';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'duracion_en_dias',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean',
    ];

    /**
     * Get all of the membresias for the TipoMembresia
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function membresias()
    {
        return $this->hasMany(Membresia::class);
    }
}
