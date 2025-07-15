<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatEstadoSolicitud extends Model
{
    protected $table = 'cat_estados_solicitudes';
    protected $primaryKey = 'id_estado_solicitud';
    public $timestamps = false;

    protected $fillable = [
        'nombre_estado',
        'descripcion',
    ];
}
