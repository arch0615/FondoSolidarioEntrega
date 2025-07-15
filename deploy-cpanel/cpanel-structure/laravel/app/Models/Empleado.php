<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'id_empleado';
    public $timestamps = false;

    protected $fillable = [
        'id_escuela',
        'nombre',
        'apellido',
        'dni',
        'cuil',
        'cargo',
        'fecha_ingreso',
        'fecha_egreso',
        'telefono',
        'email',
        'direccion',
        'activo',
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'fecha_egreso' => 'date',
        'activo' => 'boolean',
    ];

    public function escuela(): BelongsTo
    {
        return $this->belongsTo(Escuela::class, 'id_escuela', 'id_escuela');
    }

    public function beneficiariosSvo(): HasMany
    {
        return $this->hasMany(BeneficiarioSvo::class, 'id_empleado', 'id_empleado');
    }

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($empleado) {
            $empleado->beneficiariosSvo()->delete();
        });
    }
}
