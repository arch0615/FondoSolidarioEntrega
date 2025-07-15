<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudInfoAuditor extends Model
{
    protected $table = 'solicitudes_info_auditor';
    protected $primaryKey = 'id_solicitud';
    public $timestamps = false;

    protected $fillable = [
        'id_reintegro',
        'id_auditor',
        'fecha_solicitud',
        'descripcion_solicitud',
        'documentos_requeridos',
        'id_estado_solicitud',
        'id_usuario_responde',
        'fecha_respuesta',
        'observaciones_respuesta',
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_respuesta' => 'datetime',
    ];

    public function reintegro(): BelongsTo
    {
        return $this->belongsTo(Reintegro::class, 'id_reintegro', 'id_reintegro');
    }

    public function auditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_auditor', 'id_usuario');
    }

    public function estadoSolicitud(): BelongsTo
    {
        return $this->belongsTo(CatEstadoSolicitud::class, 'id_estado_solicitud', 'id_estado_solicitud');
    }

    public function usuarioResponde(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_responde', 'id_usuario');
    }
}
