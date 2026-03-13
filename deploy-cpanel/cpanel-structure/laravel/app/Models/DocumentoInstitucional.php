<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentoInstitucional extends Model
{
    protected $table = 'documentos_institucionales';
    protected $primaryKey = 'id_documento';
    public $timestamps = false;

    protected $fillable = [
        'nombre_documento',
        'titulo',
        'descripcion',
        'fecha_documento',
        'fecha_vencimiento',
        'fecha_publicacion',
        'id_usuario_carga',
        'id_user_created',
        'id_user_updated',
        'fecha_carga',
        'id_tipo_documento',
        'id_escuela',
        'is_active',
        'archivo_path',
    ];

    protected $casts = [
        'fecha_documento' => 'date',
        'fecha_vencimiento' => 'date',
        'fecha_publicacion' => 'date',
        'fecha_carga' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function escuela(): BelongsTo
    {
        return $this->belongsTo(Escuela::class, 'id_escuela', 'id_escuela');
    }

    public function escuelas(): BelongsToMany
    {
        return $this->belongsToMany(Escuela::class, 'documento_escuelas', 'id_documento', 'id_escuela');
    }

    public function usuarioCarga(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_carga', 'id_usuario');
    }

    public function tipoDocumento(): BelongsTo
    {
        return $this->belongsTo(CatTipoDocumento::class, 'id_tipo_documento', 'id_tipo_documento');
    }
    /**
     * Archivos adjuntos del documento.
     */
    public function archivos(): HasMany
    {
        return $this->hasMany(ArchivoAdjunto::class, 'id_entidad', 'id_documento')
                    ->where('tipo_entidad', 'documento_institucional');
    }

    /**
     * Verificar si tiene archivos adjuntos.
     */
    public function tieneArchivos(): bool
    {
        return $this->archivos()->exists();
    }

    /**
     * Obtener cantidad de archivos adjuntos.
     */
    public function getCantidadArchivosAttribute(): int
    {
        return $this->archivos()->count();
    }

    /**
     * Obtener nombres de escuelas separadas por coma.
     */
    public function getEscuelasNombresAttribute(): string
    {
        return $this->escuelas->pluck('nombre')->implode(', ');
    }

    /**
     * Obtener cantidad de escuelas asociadas.
     */
    public function getCantidadEscuelasAttribute(): int
    {
        return $this->escuelas()->count();
    }

    /**
     * Boot method para eventos del modelo.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($documento) {
            // Eliminar archivos físicos al eliminar la entidad
            $documento->archivos->each(function ($archivo) {
                $archivo->eliminarArchivo();
                $archivo->delete();
            });
        });
    }
}
