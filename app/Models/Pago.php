<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'membresia_id',
        'user_id',
        'sucursal_id',
        'monto',
        'metodo_pago',
        'fecha_pago',
        'notas',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'datetime',
    ];

    /**
     * Get the membresia that owns the Pago.
     */
    public function membresia(): BelongsTo
    {
        return $this->belongsTo(Membresia::class);
    }

    /**
     * Get the user who registered the pago.
     */
    public function registrador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the sucursal where the pago was made.
     */
    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class);
    }
}
