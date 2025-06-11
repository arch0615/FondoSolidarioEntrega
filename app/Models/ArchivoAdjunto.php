<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ArchivoAdjunto extends Model
{
    protected $table = 'archivos_adjuntos';
    protected $primaryKey = 'id_archivo';
    public $timestamps = false;

    protected $fillable = [
        'tipo_entidad',
        'id_entidad',
        'nombre_archivo',
        'tipo_archivo',
        'tamaño',
        'ruta_archivo',
        'descripcion',
        'id_usuario_carga',
        'fecha_carga'
    ];

    protected $casts = [
        'fecha_carga' => 'datetime',
        'tamaño' => 'integer'
    ];

    /**
     * Relación polimórfica con cualquier entidad
     */
    public function entidad(): MorphTo
    {
        return $this->morphTo('entidad', 'tipo_entidad', 'id_entidad');
    }

    /**
     * Usuario que subió el archivo
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_carga', 'id_usuario');
    }

    /**
     * Obtener la URL completa del archivo
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->ruta_archivo);
    }

    /**
     * Obtener el tamaño formateado del archivo
     */
    public function getTamañoFormateadoAttribute(): string
    {
        if (!$this->tamaño) {
            return 'N/A';
        }

        $bytes = $this->tamaño;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Verificar si el archivo es una imagen
     */
    public function esImagen(): bool
    {
        $tiposImagen = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
        return in_array(strtolower($this->tipo_archivo), $tiposImagen);
    }

    /**
     * Verificar si el archivo es un PDF
     */
    public function esPdf(): bool
    {
        return strtolower($this->tipo_archivo) === 'pdf';
    }

    /**
     * Eliminar el archivo físico del almacenamiento
     */
    public function eliminarArchivo(): bool
    {
        if (Storage::exists($this->ruta_archivo)) {
            return Storage::delete($this->ruta_archivo);
        }
        return true;
    }

    /**
     * Scope para filtrar archivos por tipo de entidad
     */
    public function scopeParaEntidad($query, string $tipoEntidad, int $idEntidad)
    {
        return $query->where('tipo_entidad', $tipoEntidad)
                    ->where('id_entidad', $idEntidad);
    }

    /**
     * Scope para filtrar archivos por tipo
     */
    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo_archivo', $tipo);
    }

    /**
     * Scope para ordenar por fecha de carga más reciente
     */
    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha_carga', 'desc');
    }
}