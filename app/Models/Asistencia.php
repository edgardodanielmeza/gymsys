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
    ];

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
