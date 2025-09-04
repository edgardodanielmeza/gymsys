<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Miembro extends Model
{
    use HasFactory;

    protected $fillable = [
        'documento_identidad',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'telefono',
        'email',
        'direccion',
        'foto_path',
        'sucursal_id',
        'activo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * Get the user's full name.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['nombres'] . ' ' . $attributes['apellidos'],
        );
    }

    /**
     * Get the sucursal that owns the Miembro.
     */
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    /**
     * Get all of the membresias for the Miembro.
     */
    public function membresias()
    {
        return $this->hasMany(Membresia::class);
    }

    /**
     * Get the miembro's most recent active membresia.
     */
    public function membresiaActiva()
    {
        return $this->hasOne(Membresia::class)->where('estado', 'activa')->latest('fecha_fin');
    }
}
