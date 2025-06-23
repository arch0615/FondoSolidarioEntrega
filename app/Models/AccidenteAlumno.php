<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccidenteAlumno extends Model
{
    protected $table = 'accidente_alumnos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_accidente',
        'id_alumno',
    ];

    public function accidente(): BelongsTo
    {
        return $this->belongsTo(Accidente::class, 'id_accidente', 'id_accidente');
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'id_alumno', 'id_alumno');
    }
}
