<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeneficiarioSvo extends Model
{
    protected $table = 'beneficiarios_svo';
    protected $primaryKey = 'id_beneficiario';
    public $timestamps = false;

    protected $fillable = [
        'id_empleado',
        'id_escuela',
        'nombre',
        'apellido',
        'dni',
        'porcentaje',
        'fecha_alta',
        'activo',
        'id_parentesco',
    ];

    protected $casts = [
        'porcentaje' => 'decimal:2',
        'fecha_alta' => 'date',
        'activo' => 'boolean',
    ];

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id_empleado');
    }

    public function escuela(): BelongsTo
    {
        return $this->belongsTo(Escuela::class, 'id_escuela', 'id_escuela');
    }

    public function parentesco(): BelongsTo
    {
        return $this->belongsTo(CatParentesco::class, 'id_parentesco', 'id_parentesco');
    }
}
