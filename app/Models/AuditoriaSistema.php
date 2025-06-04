<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditoriaSistema extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'auditoria_sistema';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_auditoria';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_usuario',
        'fecha_hora',
        'accion',
        'tabla_afectada',
        'id_registro',
        'datos_anteriores',
        'datos_nuevos',
        'ip_usuario',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    /**
     * Get the user that owns the audit record.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Create a new audit record.
     */
    public static function registrarAccion($idUsuario, $accion, $tablaAfectada = null, $idRegistro = null, $datosAnteriores = null, $datosNuevos = null)
    {
        return self::create([
            'id_usuario' => $idUsuario,
            'fecha_hora' => now(),
            'accion' => $accion,
            'tabla_afectada' => $tablaAfectada,
            'id_registro' => $idRegistro,
            'datos_anteriores' => $datosAnteriores ? json_encode($datosAnteriores) : null,
            'datos_nuevos' => $datosNuevos ? json_encode($datosNuevos) : null,
            'ip_usuario' => request()->ip(),
        ]);
    }
}