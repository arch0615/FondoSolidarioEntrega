<?php

namespace App\Http\Controllers;

use App\Models\Derivacion;
use Illuminate\Http\Request;

class DerivacionController extends Controller
{
    public function print($id)
    {
        $derivacion = Derivacion::with(['accidente.escuela', 'alumno', 'prestador'])->findOrFail($id);
        return view('derivaciones.print', compact('derivacion'));
    }
}
