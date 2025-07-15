<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prestador extends Model
{
    protected $table = 'prestadores';
    protected $primaryKey = 'id_prestador';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'es_sistema_emergencias',
        'direccion',
        'telefono',
        'email',
        'especialidades',
        'activo',
        'id_tipo_prestador',
    ];

    protected $casts = [
        'es_sistema_emergencias' => 'boolean',
        'activo' => 'boolean',
    ];

    public function tipoPrestador(): BelongsTo
    {
        return $this->belongsTo(CatTipoPrestador::class, 'id_tipo_prestador', 'id_tipo_prestador');
    }

    public function derivaciones(): HasMany
    {
        return $this->hasMany(Derivacion::class, 'id_prestador', 'id_prestador');
    }
}
