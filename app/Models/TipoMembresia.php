<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoMembresia extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipos_membresia';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'duracion_dias',
        'activo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean',
    ];

    /**
     * Get all of the a a for the TipoMembresia
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function membresias(): HasMany
    {
        return $this->hasMany(Membresia::class);
    }
}
