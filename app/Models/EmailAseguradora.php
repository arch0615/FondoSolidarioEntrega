<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailAseguradora extends Model
{
    protected $table = 'emails_aseguradora';
    protected $primaryKey = 'id_email_aseguradora';

    protected $fillable = [
        'email',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
