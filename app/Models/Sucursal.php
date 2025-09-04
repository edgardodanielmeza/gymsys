<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sucursales'; // <-- ESTA ES LA LÍNEA DE LA SOLUCIÓN

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
