<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatTipoGasto extends Model
{
    protected $table = 'cat_tipos_gastos';
    protected $primaryKey = 'id_tipo_gasto';
    public $timestamps = false;

    protected $fillable = [
        'nombre_tipo_gasto',
        'descripcion',
    ];
}
