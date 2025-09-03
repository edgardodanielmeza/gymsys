<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'asistencias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'miembro_id',
        'sucursal_id',
        'fecha_ingreso',
        'fecha_salida',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_ingreso' => 'datetime',
        'fecha_salida' => 'datetime',
    ];

    /**
     * Get the miembro that owns the Asistencia.
     */
    public function miembro(): BelongsTo
    {
        return $this->belongsTo(Miembro::class);
    }

    /**
     * Get the sucursal that owns the Asistencia.
     */
    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class);
    }
}
