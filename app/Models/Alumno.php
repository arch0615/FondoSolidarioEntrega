<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alumnos';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_alumno';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_escuela',
        'nombre',
        'apellido',
        'dni',
        'cuil',
        'sala_grado_curso',
        'nombre_padre_madre',
        'telefono_contacto',
        'fecha_nacimiento',
        'activo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'fecha_nacimiento' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * Get the school that the student belongs to.
     */
    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela', 'id_escuela');
    }

    /**
     * Get the student's full name.
     *
     * @return string
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }
}
