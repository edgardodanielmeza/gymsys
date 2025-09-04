<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'membresia_id',
        'user_id',
        'monto',
        'metodo_pago',
        'fecha_pago',
        'notas',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'datetime',
    ];

    /**
     * Get the membresia that owns the Pago.
     */
    public function membresia()
    {
        return $this->belongsTo(Membresia::class);
    }

    /**
     * Get the user (employee) who registered the payment.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
