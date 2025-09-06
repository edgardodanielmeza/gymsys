<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'miembro_id',
        'sucursal_id',
        'user_id',
        'fecha_hora_entrada',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_hora_entrada' => 'datetime',
    ];

    /**
     * We don't use updated_at in this table.
     */
    const UPDATED_AT = null;

    /**
     * Get the miembro associated with the asistencia.
     */
    public function miembro()
    {
        return $this->belongsTo(Miembro::class);
    }

    /**
     * Get the sucursal associated with the asistencia.
     */
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    /**
     * Get the user (employee) who registered the asistencia.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
