<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatTipoPrestador extends Model
{
    protected $table = 'cat_tipos_prestadores';
    protected $primaryKey = 'id_tipo_prestador';
    public $timestamps = false;

    protected $fillable = [
        'nombre_tipo_prestador',
        'descripcion',
    ];
}
