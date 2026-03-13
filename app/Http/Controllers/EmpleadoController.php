<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function printBeneficiarios($id)
    {
        $empleado = Empleado::with(['escuela', 'beneficiariosSvo.parentesco'])
            ->findOrFail($id);

        return view('empleados.print-beneficiarios', compact('empleado'));
    }
}