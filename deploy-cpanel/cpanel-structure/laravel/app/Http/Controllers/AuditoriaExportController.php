<?php

namespace App\Http\Controllers;

use App\Models\AuditoriaSistema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AuditoriaExportController extends Controller
{
    private function getAuditoriaFiltrada(Request $request, $tipo)
    {
        $query = AuditoriaSistema::query()->with('usuario');

        if ($tipo === 'accesos') {
            $query->whereIn('accion', ['LOGIN', 'LOGOUT']);
        } else {
            $query->whereNotIn('accion', ['LOGIN', 'LOGOUT']);
        }

        // Aplicar filtros de la request
        if ($request->has('filtro_usuario') && $request->filtro_usuario) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('nombre_completo', 'like', '%' . $request->filtro_usuario . '%');
            });
        }
        if ($request->has('filtro_accion') && $request->filtro_accion) {
            $query->where('accion', $request->filtro_accion);
        }
        if ($request->has('filtro_tabla') && $request->filtro_tabla) {
            $query->where('tabla_afectada', 'like', '%' . $request->filtro_tabla . '%');
        }
        if ($request->has('filtro_fecha_inicio') && $request->filtro_fecha_inicio) {
            $query->whereDate('fecha_hora', '>=', $request->filtro_fecha_inicio);
        }
        if ($request->has('filtro_fecha_fin') && $request->filtro_fecha_fin) {
            $query->whereDate('fecha_hora', '<=', $request->filtro_fecha_fin);
        }

        return $query->orderBy('fecha_hora', 'desc')->get();
    }

    // --- EXPORTACIÓN DE ACCESOS ---

    public function exportarAccesosCSV(Request $request)
    {
        $registros = $this->getAuditoriaFiltrada($request, 'accesos');
        $filename = 'auditoria_accesos_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($registros) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM para UTF-8
            
            fputcsv($file, ['Fecha y Hora', 'Usuario', 'Acción', 'IP']);

            foreach ($registros as $registro) {
                fputcsv($file, [
                    $registro->fecha_hora->format('d/m/Y H:i:s'),
                    $registro->usuario->nombre_completo ?? 'N/A',
                    $registro->accion,
                    $registro->ip_usuario,
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportarAccesosExcel(Request $request)
    {
        $registros = $this->getAuditoriaFiltrada($request, 'accesos');
        $filename = 'auditoria_accesos_' . date('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $html = view('exports.auditoria_accesos_excel', compact('registros'))->render();
        return Response::make($html, 200, $headers);
    }

    public function exportarAccesosPDF(Request $request)
    {
        $registros = $this->getAuditoriaFiltrada($request, 'accesos');
        $html = view('exports.auditoria_accesos_pdf', compact('registros'))->render();
        
        $headers = [
            'Content-Type' => 'text/html; charset=UTF-8',
        ];

        return Response::make($html, 200, $headers);
    }

    // --- EXPORTACIÓN DE OPERACIONES ---

    public function exportarOperacionesCSV(Request $request)
    {
        $registros = $this->getAuditoriaFiltrada($request, 'operaciones');
        $filename = 'auditoria_operaciones_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($registros) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, ['Fecha y Hora', 'Usuario', 'Acción', 'Tabla Afectada', 'ID Registro', 'Datos Anteriores', 'Datos Nuevos']);

            foreach ($registros as $registro) {
                fputcsv($file, [
                    $registro->fecha_hora->format('d/m/Y H:i:s'),
                    $registro->usuario->nombre_completo ?? 'N/A',
                    $registro->accion,
                    $registro->tabla_afectada,
                    $registro->id_registro,
                    $registro->datos_anteriores,
                    $registro->datos_nuevos,
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportarOperacionesExcel(Request $request)
    {
        $registros = $this->getAuditoriaFiltrada($request, 'operaciones');
        $filename = 'auditoria_operaciones_' . date('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $html = view('exports.auditoria_operaciones_excel', compact('registros'))->render();
        return Response::make($html, 200, $headers);
    }

    public function exportarOperacionesPDF(Request $request)
    {
        $registros = $this->getAuditoriaFiltrada($request, 'operaciones');
        $html = view('exports.auditoria_operaciones_pdf', compact('registros'))->render();
        
        $headers = [
            'Content-Type' => 'text/html; charset=UTF-8',
        ];

        return Response::make($html, 200, $headers);
    }
}