<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario_destino',
        'tipo_notificacion',
        'titulo',
        'mensaje',
        'id_entidad_referencia',
        'tipo_entidad',
        'fecha_creacion',
        'leida',
        'fecha_lectura',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'leida' => 'boolean',
        'fecha_lectura' => 'datetime',
    ];

    public function usuarioDestino(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_destino', 'id_usuario');
    }
}
