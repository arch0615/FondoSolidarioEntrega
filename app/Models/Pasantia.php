<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pasantia extends Model
{
    protected $table = 'pasantias';
    protected $primaryKey = 'id_pasantia';
    public $timestamps = false;

    protected $fillable = [
        'id_escuela',
        'id_alumno',
        'empresa',
        'direccion_empresa',
        'tutor_empresa',
        'fecha_inicio',
        'fecha_fin',
        'horario',
        'descripcion_tareas',
        'id_usuario_carga',
        'fecha_carga',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_carga' => 'datetime',
    ];

    public function escuela(): BelongsTo
    {
        return $this->belongsTo(Escuela::class, 'id_escuela', 'id_escuela');
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'id_alumno', 'id_alumno');
    }

    public function usuarioCarga(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_carga', 'id_usuario');
    }

    /**
     * Accessor para verificar si la pasantía está activa
     */
    public function getEsActivaAttribute(): bool
    {
        return $this->fecha_fin ? $this->fecha_fin >= now()->toDateString() : true;
    }

    /**
     * Accessor para el período formateado
     */
    public function getPeriodoFormateadoAttribute(): string
    {
        $inicio = $this->fecha_inicio ? $this->fecha_inicio->format('d/m/Y') : 'Sin definir';
        $fin = $this->fecha_fin ? $this->fecha_fin->format('d/m/Y') : 'Sin definir';
        return "{$inicio} a {$fin}";
    }

    /**
     * Scope para filtrar pasantías activas
     */
    public function scopeActivas($query)
    {
        return $query->where('fecha_fin', '>=', now()->toDateString())
                    ->orWhereNull('fecha_fin');
    }

    /**
     * Scope para filtrar por escuela
     */
    public function scopePorEscuela($query, $idEscuela)
    {
        return $query->where('id_escuela', $idEscuela);
    }
}
