<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatEstadoReintegro extends Model
{
    protected $table = 'cat_estados_reintegros';
    protected $primaryKey = 'id_estado_reintegro';
    public $timestamps = false;

    protected $fillable = [
        'nombre_estado',
        'descripcion',
    ];
}
