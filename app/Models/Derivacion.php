<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Derivacion extends Model
{
    protected $table = 'derivaciones';
    protected $primaryKey = 'id_derivacion';
    public $timestamps = false;

    protected $fillable = [
        'id_accidente',
        'id_alumno',
        'id_prestador',
        'fecha_derivacion',
        'hora_derivacion',
        'medico_deriva',
        'diagnostico_inicial',
        'acompanante',
        'observaciones',
        'sello_escuela',
        'firma_autorizada',
        'impresa',
        'fecha_impresion',
    ];

    protected $casts = [
        'fecha_derivacion' => 'date',
        'hora_derivacion' => 'datetime:H:i',
        'impresa' => 'boolean',
        'fecha_impresion' => 'datetime',
    ];

    public function accidente(): BelongsTo
    {
        return $this->belongsTo(Accidente::class, 'id_accidente', 'id_accidente');
    }

    public function prestador(): BelongsTo
    {
        return $this->belongsTo(Prestador::class, 'id_prestador', 'id_prestador');
    }
    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'id_alumno', 'id_alumno');
    }
}
