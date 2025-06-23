<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumnoSalida extends Model
{
    protected $table = 'alumnos_salidas';
    protected $primaryKey = 'id_alumno_salida';
    public $timestamps = false;

    protected $fillable = [
        'id_salida',
        'id_alumno',
        'autorizado',
    ];

    protected $casts = [
        'autorizado' => 'boolean',
    ];

    public function salida(): BelongsTo
    {
        return $this->belongsTo(SalidaEducativa::class, 'id_salida', 'id_salida');
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'id_alumno', 'id_alumno');
    }
}
