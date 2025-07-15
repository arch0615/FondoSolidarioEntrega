<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalidaEducativa extends Model
{
    protected $table = 'salidas_educativas';
    protected $primaryKey = 'id_salida';
    public $timestamps = false;

    protected $fillable = [
        'id_escuela',
        'id_usuario_carga',
        'fecha_salida',
        'hora_salida',
        'hora_regreso',
        'destino',
        'proposito',
        'grado_curso',
        'cantidad_alumnos',
        'docentes_acompanantes',
        'transporte',
        'fecha_carga',
    ];

    protected $casts = [
        'fecha_salida' => 'date',
        'hora_salida' => 'datetime:H:i',
        'hora_regreso' => 'datetime:H:i',
        'fecha_carga' => 'datetime',
    ];

    public function escuela(): BelongsTo
    {
        return $this->belongsTo(Escuela::class, 'id_escuela', 'id_escuela');
    }

    public function usuarioCarga(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_carga', 'id_usuario');
    }

    public function alumnos(): HasMany
    {
        return $this->hasMany(AlumnoSalida::class, 'id_salida', 'id_salida');
    }
}
