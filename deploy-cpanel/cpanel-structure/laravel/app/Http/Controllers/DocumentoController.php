<?php

namespace App\Http\Controllers;

use App\Models\DocumentoInstitucional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentoController extends Controller
{
    public function descargarArchivo($documentoId)
    {
        $documento = DocumentoInstitucional::with('archivos')->findOrFail($documentoId);

        // Verificar que el usuario tenga acceso al documento (pertenece a su escuela)
        $tieneAcceso = $documento->escuelas()->where('escuelas.id_escuela', Auth::user()->id_escuela)->exists();

        if (!$tieneAcceso) {
            abort(403, 'No tienes acceso a este documento.');
        }

        if (!$documento->tieneArchivos()) {
            abort(404, 'El documento no tiene archivos disponibles.');
        }

        // Obtener el primer archivo disponible
        $archivo = $documento->archivos->first();
        
        if (!$archivo || !Storage::disk('public')->exists($archivo->ruta_archivo)) {
            abort(404, 'El archivo no está disponible.');
        }

        $filePath = storage_path('app/public/' . $archivo->ruta_archivo);
        
        if (!file_exists($filePath)) {
            abort(404, 'El archivo no existe.');
        }
        
        return response()->download($filePath, $archivo->nombre_archivo);
    }

    public function descargarArchivoIndividual($archivoId)
    {
        $archivo = \App\Models\ArchivoAdjunto::findOrFail($archivoId);
        
        // Verificar que el archivo pertenece a un documento institucional
        if ($archivo->tipo_entidad !== 'documento_institucional') {
            abort(403, 'Tipo de archivo no válido.');
        }

        // Obtener el documento asociado
        $documento = DocumentoInstitucional::findOrFail($archivo->id_entidad);

        // Verificar que el usuario tenga acceso al documento (pertenece a su escuela)
        $tieneAcceso = $documento->escuelas()->where('escuelas.id_escuela', Auth::user()->id_escuela)->exists();

        if (!$tieneAcceso) {
            abort(403, 'No tienes acceso a este archivo.');
        }

        if (!Storage::disk('public')->exists($archivo->ruta_archivo)) {
            abort(404, 'El archivo no está disponible.');
        }

        $filePath = storage_path('app/public/' . $archivo->ruta_archivo);
        
        if (!file_exists($filePath)) {
            abort(404, 'El archivo no existe.');
        }
        
        return response()->download($filePath, $archivo->nombre_archivo);
    }
}