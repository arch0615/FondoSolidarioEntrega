<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentoInstitucional extends Model
{
    protected $table = 'documentos_institucionales';
    protected $primaryKey = 'id_documento';
    public $timestamps = false;

    protected $fillable = [
        'id_escuela',
        'nombre_documento',
        'descripcion',
        'fecha_documento',
        'fecha_vencimiento',
        'id_usuario_carga',
        'fecha_carga',
        'id_tipo_documento',
    ];

    protected $casts = [
        'fecha_documento' => 'date',
        'fecha_vencimiento' => 'date',
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
