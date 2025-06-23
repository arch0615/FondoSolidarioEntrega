<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatEstadoAccidente extends Model
{
    protected $table = 'cat_estados_accidentes';
    protected $primaryKey = 'id_estado_accidente';
    public $timestamps = false;

    protected $fillable = [
        'nombre_estado',
        'descripcion',
    ];
}
