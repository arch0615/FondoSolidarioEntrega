<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialReintegro extends Model
{
    protected $table = 'historial_reintegros';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_reintegro',
        'id_usuario',
        'fecha_hora',
        'mensaje',
        'accion',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    /**
     * Relación con el reintegro
     */
    public function reintegro(): BelongsTo
    {
        return $this->belongsTo(Reintegro::class, 'id_reintegro', 'id_reintegro');
    }

    /**
     * Relación con el usuario que realizó la acción
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Scope para ordenar por fecha más reciente primero
     */
    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha_hora', 'desc');
    }

    /**
     * Scope para filtrar por reintegro
     */
    public function scopeDeReintegro($query, int $idReintegro)
    {
        return $query->where('id_reintegro', $idReintegro);
    }

    /**
     * Scope para filtrar por acción
     */
    public function scopePorAccion($query, string $accion)
    {
        return $query->where('accion', $accion);
    }

    /**
     * Obtener el texto descriptivo de la acción
     */
    public function getTextoAccionAttribute(): string
    {
        return match($this->accion) {
            'aceptar' => 'Aprobó el reintegro',
            'rechazar' => 'Rechazó el reintegro',
            'solicitar_informacion' => 'Solicitó información adicional',
            'mensaje' => 'Envió un mensaje',
            'respuesta_escuela' => 'Envió una respuesta',
            default => 'Realizó una acción'
        };
    }

    /**
     * Obtener la clase CSS para el color de la acción
     */
    public function getColorAccionAttribute(): string
    {
        return match($this->accion) {
            'aceptar' => 'text-success-600 bg-success-50',
            'rechazar' => 'text-danger-600 bg-danger-50',
            'solicitar_informacion' => 'text-warning-600 bg-warning-50',
            'mensaje' => 'text-info-600 bg-info-50',
            'respuesta_escuela' => 'text-indigo-600 bg-indigo-50',
            default => 'text-secondary-600 bg-secondary-50'
        };
    }
}