<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CatTipoGasto extends Model
{
    protected $table = 'cat_tipos_gastos';
    protected $primaryKey = 'id_tipo_gasto';
    public $timestamps = false;

    protected $fillable = [
        'nombre_tipo_gasto',
        'descripcion',
    ];

    public function reintegros(): BelongsToMany
    {
        return $this->belongsToMany(Reintegro::class, 'reintegro_tipos_gastos', 'id_tipo_gasto', 'id_reintegro');
    }
}
