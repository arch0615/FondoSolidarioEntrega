<?php

namespace App\Http\Controllers;

use App\Models\Accidente;
use App\Models\ArchivoAdjunto;
use App\Models\Derivacion;
use App\Models\Pasantia;
use App\Models\SalidaEducativa;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintPdfController extends Controller
{
    public function accidente($id)
    {
        $accidente = Accidente::with(['escuela', 'alumnos.alumno', 'estado'])->findOrFail($id);
        $archivos = ArchivoAdjunto::paraEntidad('accidente', $id)->recientes()->get();

        $pdf = Pdf::loadView('pdf.accidente', compact('accidente', 'archivos'))
            ->setPaper('a4');

        $filename = 'Accidente_' . ($accidente->numero_expediente ?? $id) . '.pdf';

        return $pdf->stream($filename);
    }

    public function dossier($id)
    {
        $accidente = Accidente::with([
            'escuela', 'alumnos.alumno', 'estado',
            'derivaciones.alumno', 'derivaciones.prestador',
            'reintegros.alumno', 'reintegros.estadoReintegro', 'reintegros.tiposGastos'
        ])->findOrFail($id);
        $archivos = ArchivoAdjunto::paraEntidad('accidente', $id)->recientes()->get();

        $pdf = Pdf::loadView('pdf.dossier', compact('accidente', 'archivos'))
            ->setPaper('a4');

        $filename = 'Expediente_' . ($accidente->numero_expediente ?? $id) . '.pdf';

        return $pdf->stream($filename);
    }

    public function pasantia($id)
    {
        $pasantia = Pasantia::with(['escuela', 'alumno'])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.pasantia', compact('pasantia'))
            ->setPaper('a4');

        $filename = 'Pasantia_' . ($pasantia->alumno->apellido ?? $id) . '.pdf';

        return $pdf->stream($filename);
    }

    public function salidaEducativa($id)
    {
        $salida = SalidaEducativa::with('escuela')->findOrFail($id);
        $archivos = ArchivoAdjunto::paraEntidad('salida_educativa', $id)->recientes()->get();

        $pdf = Pdf::loadView('pdf.salida_educativa', compact('salida', 'archivos'))
            ->setPaper('a4');

        $filename = 'SalidaEducativa_' . str_replace(' ', '_', $salida->destino) . '.pdf';

        return $pdf->stream($filename);
    }

    public function derivacion($id)
    {
        $derivacion = Derivacion::with(['alumno', 'accidente.escuela', 'prestador'])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.derivacion', compact('derivacion'))
            ->setPaper('a4');

        $filename = 'Derivacion_' . ($derivacion->alumno->apellido ?? $id) . '.pdf';

        return $pdf->stream($filename);
    }
}
