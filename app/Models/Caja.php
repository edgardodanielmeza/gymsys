<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $table = 'cajas';

    protected $fillable = [
        'user_id',
        'sucursal_id',
        'monto_inicial',
        'monto_final_calculado',
        'monto_final_real',
        'diferencia',
        'fecha_cierre',
        'notas',
        'estado',
    ];

    protected $casts = [
        'monto_inicial' => 'decimal:2',
        'monto_final_calculado' => 'decimal:2',
        'monto_final_real' => 'decimal:2',
        'diferencia' => 'decimal:2',
        'fecha_cierre' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
