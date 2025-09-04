<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Miembro extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'miembros';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'documento_identidad',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'telefono',
        'email',
        'direccion',
        'foto_path',
        'sucursal_registro_id',
        'user_id',
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
     * Get the sucursal where the member registered.
     */
    public function sucursalDeRegistro(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_registro_id');
    }

    /**
     * Get the user account associated with the member.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the memberships for the member.
     */
    public function membresias(): HasMany
    {
        return $this->hasMany(Membresia::class);
    }
}
