<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'caja_id',
        'miembro_id',
        'user_id',
        'total',
        'metodo_pago',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }

    public function miembro()
    {
        return $this->belongsTo(Miembro::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(VentaItem::class);
    }
}
