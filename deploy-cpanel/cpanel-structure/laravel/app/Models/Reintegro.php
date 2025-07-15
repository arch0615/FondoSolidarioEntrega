<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reintegro extends Model
{
    protected $table = 'reintegros';
    protected $primaryKey = 'id_reintegro';
    public $timestamps = false;

    protected $fillable = [
        'id_accidente',
        'id_alumno',
        'id_usuario_solicita',
        'fecha_solicitud',
        'id_tipo_gasto',
        'descripcion_gasto',
        'monto_solicitado',
        'id_estado_reintegro',
        'requiere_mas_info',
        'id_medico_auditor',
        'fecha_auditoria',
        'observaciones_auditor',
        'monto_autorizado',
        'fecha_autorizacion',
        'fecha_pago',
        'numero_transferencia',
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'monto_solicitado' => 'decimal:2',
        'requiere_mas_info' => 'boolean',
        'fecha_auditoria' => 'datetime',
        'monto_autorizado' => 'decimal:2',
        'fecha_autorizacion' => 'datetime',
        'fecha_pago' => 'date',
    ];

    public function accidente(): BelongsTo
    {
        return $this->belongsTo(Accidente::class, 'id_accidente', 'id_accidente');
    }

    public function usuarioSolicita(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_solicita', 'id_usuario');
    }

    public function tipoGasto(): BelongsTo
    {
        return $this->belongsTo(CatTipoGasto::class, 'id_tipo_gasto', 'id_tipo_gasto');
    }

    public function estadoReintegro(): BelongsTo
    {
        return $this->belongsTo(CatEstadoReintegro::class, 'id_estado_reintegro', 'id_estado_reintegro');
    }

    public function medicoAuditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_medico_auditor', 'id_usuario');
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'id_alumno', 'id_alumno');
    }

    /**
     * Archivos adjuntos del reintegro
     */
    public function archivos(): HasMany
    {
        return $this->hasMany(ArchivoAdjunto::class, 'id_entidad', 'id_reintegro')
                    ->where('tipo_entidad', 'reintegro');
    }

    /**
     * Verificar si tiene archivos adjuntos
     */
    public function tieneArchivos(): bool
    {
        return $this->archivos()->count() > 0;
    }

    /**
     * Obtener cantidad de archivos adjuntos
     */
    public function getCantidadArchivosAttribute(): int
    {
        return $this->archivos()->count();
    }

    /**
     * Boot method para eventos del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($reintegro) {
            // Eliminar archivos físicos al eliminar la entidad
            $reintegro->archivos->each(function ($archivo) {
                $archivo->eliminarArchivo();
                $archivo->delete();
            });
        });
    }
}
