<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membresia extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'membresias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'miembro_id',
        'tipo_membresia_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    /**
     * Get the miembro that owns the Membresia.
     */
    public function miembro(): BelongsTo
    {
        return $this->belongsTo(Miembro::class);
    }

    /**
     * Get the tipoMembresia that owns the Membresia.
     */
    public function tipoMembresia(): BelongsTo
    {
        return $this->belongsTo(TipoMembresia::class);
    }

    /**
     * Get all of the pagos for the Membresia.
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }
}
