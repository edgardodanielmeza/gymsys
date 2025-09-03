<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Miembro extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'documento_identidad',
        'nombre',
        'apellido',
        'telefono',
        'email',
        'fecha_nacimiento',
        'foto_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    /**
     * Get all of the membresias for the Miembro.
     */
    public function membresias(): HasMany
    {
        return $this->hasMany(Membresia::class);
    }

    /**
     * Get the current active membresia for the Miembro.
     */
    public function membresiaActiva(): HasOne
    {
        return $this->hasOne(Membresia::class)->where('estado', 'activa')->latest('fecha_inicio');
    }

    /**
     * Get all of the asistencias for the Miembro.
     */
    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class);
    }
}
