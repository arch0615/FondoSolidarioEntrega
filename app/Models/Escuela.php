<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    use HasFactory;

    protected $table = 'escuelas';
    protected $primaryKey = 'id_escuela';
    public $timestamps = false;

    protected $fillable = [
        'codigo_escuela',
        'nombre',
        'direccion',
        'telefono',
        'email',
        'aporte_por_alumno',
        'fecha_alta',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_alta' => 'date',
        'aporte_por_alumno' => 'decimal:2',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_escuela', 'id_escuela');
    }

    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'id_escuela', 'id_escuela');
    }

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'id_escuela', 'id_escuela');
    }

    public function accidentes()
    {
        return $this->hasMany(Accidente::class, 'id_escuela', 'id_escuela');
    }

    public function salidasEducativas()
    {
        return $this->hasMany(SalidaEducativa::class, 'id_escuela', 'id_escuela');
    }

    public function pasantias()
    {
        return $this->hasMany(Pasantia::class, 'id_escuela', 'id_escuela');
    }

    public function beneficiariosSvo()
    {
        return $this->hasMany(BeneficiarioSvo::class, 'id_escuela', 'id_escuela');
    }
}