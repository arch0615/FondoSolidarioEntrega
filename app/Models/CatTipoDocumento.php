<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatTipoDocumento extends Model
{
    protected $table = 'cat_tipos_documentos';
    protected $primaryKey = 'id_tipo_documento';
    public $timestamps = false;

    protected $fillable = [
        'nombre_tipo_documento',
    ];
}
