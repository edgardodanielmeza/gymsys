<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'capacidad_maxima',
        'horario_operacion',
        'activo',
    ];

    /**
     * Get the users for the branch.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
