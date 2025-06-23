<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatParentesco extends Model
{
    protected $table = 'cat_parentescos';
    protected $primaryKey = 'id_parentesco';
    public $timestamps = false;

    protected $fillable = [
        'nombre_parentesco',
    ];
}
