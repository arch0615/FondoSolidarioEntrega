<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fallecimiento extends Model
{
    protected $table = 'fallecimientos';
    protected $primaryKey = 'id_fallecimiento';
    public $timestamps = false;

    protected $fillable = [
        'id_empleado',
        'fecha_fallecimiento',
        'causa',
        'lugar_fallecimiento',
        'observaciones',
        'id_usuario_carga',
        'fecha_carga',
    ];

    protected $casts = [
        'fecha_fallecimiento' => 'date',
        'fecha_carga' => 'datetime',
    ];

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id_empleado');
    }

    public function usuarioCarga(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_carga', 'id_usuario');
    }
}
