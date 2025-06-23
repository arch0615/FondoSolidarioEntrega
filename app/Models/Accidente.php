<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\CatEstadoAccidente;
use App\Models\AccidenteAlumno;
use App\Models\Derivacion;
use App\Models\Reintegro;
use App\Models\Escuela;
use App\Models\User;

class Accidente extends Model
{
    protected $table = 'accidentes';
    protected $primaryKey = 'id_accidente';
    public $timestamps = false;

    protected $fillable = [
        'id_escuela',
        'fecha_accidente',
        'hora_accidente',
        'lugar_accidente',
        'descripcion_accidente',
        'tipo_lesion',
        'protocolo_activado',
        'llamada_emergencia',
        'hora_llamada',
        'servicio_emergencia',
        'numero_expediente',
        'id_estado_accidente',
        'fecha_carga',
        'id_usuario_carga'
    ];

    protected $casts = [
        'fecha_accidente' => 'date',
        'hora_accidente' => 'datetime:H:i',
        'hora_llamada' => 'datetime:H:i',
        'fecha_carga' => 'datetime',
        'protocolo_activado' => 'boolean',
        'llamada_emergencia' => 'boolean'
    ];

    /**
     * Relación con la escuela
     */
    public function escuela(): BelongsTo
    {
        return $this->belongsTo(Escuela::class, 'id_escuela', 'id_escuela');
    }

    /**
     * Usuario que registró el accidente
     */
    public function usuarioCarga(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_carga', 'id_usuario');
    }

    /**
     * Estado del accidente
     */
    public function estado(): BelongsTo
    {
        return $this->belongsTo(CatEstadoAccidente::class, 'id_estado_accidente', 'id_estado_accidente');
    }

    /**
     * Alumnos involucrados en el accidente
     */
    public function alumnos(): HasMany
    {
        return $this->hasMany(AccidenteAlumno::class, 'id_accidente', 'id_accidente');
    }

    /**
     * Archivos adjuntos del accidente
     */
    public function archivos(): HasMany
    {
        return $this->hasMany(ArchivoAdjunto::class, 'id_entidad', 'id_accidente')
                    ->where('tipo_entidad', 'accidente');
    }

    /**
     * Derivaciones médicas del accidente
     */
    public function derivaciones(): HasMany
    {
        return $this->hasMany(Derivacion::class, 'id_accidente', 'id_accidente');
    }

    /**
     * Reintegros relacionados al accidente
     */
    public function reintegros(): HasMany
    {
        return $this->hasMany(Reintegro::class, 'id_accidente', 'id_accidente');
    }


    /**
     * Generar número de expediente automático
     */
    public function generarNumeroExpediente(): string
    {
        $año = now()->year;
        $ultimoNumero = static::whereYear('fecha_carga', $año)
            ->whereNotNull('numero_expediente')
            ->count();
        
        $numero = str_pad($ultimoNumero + 1, 3, '0', STR_PAD_LEFT);
        return "EXP-{$año}-{$numero}";
    }

    /**
     * Scope para filtrar accidentes de una escuela específica
     */
    public function scopeDeEscuela($query, int $idEscuela)
    {
        return $query->where('id_escuela', $idEscuela);
    }

    /**
     * Scope para filtrar accidentes por fecha
     */
    public function scopeEnFecha($query, string $fecha)
    {
        return $query->whereDate('fecha_accidente', $fecha);
    }

    /**
     * Scope para filtrar accidentes por mes
     */
    public function scopeEnMes($query, int $mes, int $año = null)
    {
        $año = $año ?? now()->year;
        return $query->whereMonth('fecha_accidente', $mes)
                    ->whereYear('fecha_accidente', $año);
    }

    /**
     * Scope para accidentes con protocolo activado
     */
    public function scopeConProtocolo($query)
    {
        return $query->where('protocolo_activado', true);
    }

    /**
     * Scope para accidentes recientes
     */
    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha_accidente', 'desc')
                    ->orderBy('hora_accidente', 'desc');
    }

    /**
     * Obtener el nombre completo de los alumnos involucrados
     */
    public function getNombresAlumnosAttribute(): string
    {
        return $this->alumnos()
            ->with('alumno')
            ->get()
            ->pluck('alumno.nombre_completo')
            ->join(', ');
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

        static::creating(function ($accidente) {
            if (empty($accidente->numero_expediente)) {
                $accidente->numero_expediente = $accidente->generarNumeroExpediente();
            }
            if (empty($accidente->fecha_carga)) {
                $accidente->fecha_carga = now();
            }
        });

        static::deleting(function ($accidente) {
            // Eliminar archivos físicos al eliminar el accidente
            $accidente->archivos->each(function ($archivo) {
                $archivo->eliminarArchivo();
                $archivo->delete();
            });
        });
    }
}