<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reintegro;
use Illuminate\Support\Facades\Response;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

class ReintegroExportController extends Controller
{
    public function exportarCSV(Request $request)
    {
        $reintegros = $this->getReintegrosQuery($request)->get();
        $filename = 'reintegros_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($reintegros) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF"); // BOM for UTF-8

            fputcsv($file, [
                'ID Reintegro',
                'ID Accidente',
                'Alumno',
                'Escuela',
                'Fecha Solicitud',
                'Monto Solicitado',
                'Estado',
            ]);

            foreach ($reintegros as $reintegro) {
                fputcsv($file, [
                    $reintegro->id_reintegro,
                    $reintegro->accidente->id_accidente_entero ?? 'N/A',
                    export_clean($reintegro->alumno->nombre_completo ?? 'N/A'),
                    export_clean($reintegro->accidente->escuela->nombre ?? 'N/A'),
                    $reintegro->fecha_solicitud ? $reintegro->fecha_solicitud->format('d/m/Y') : '',
                    $reintegro->monto_solicitado,
                    export_clean($reintegro->estadoReintegro->descripcion ?? 'Sin Estado'),
                ]);
            }

            fclose($file);
        };

        AuditoriaService::registrarConsulta('reintegros_export_csv', $request->all());
        return response()->stream($callback, 200, $headers);
    }

    public function exportarExcel(Request $request)
    {
        $reintegros = $this->getReintegrosQuery($request)->get();
        $filename = 'reintegros_' . date('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $html = $this->generarHTMLParaExcel($reintegros);
        AuditoriaService::registrarConsulta('reintegros_export_excel', $request->all());
        return Response::make($html, 200, $headers);
    }

    private function generarHTMLParaExcel($reintegros)
    {
        $html = '<?xml version="1.0" encoding="UTF-8"?><Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"><Styles><Style ss:ID="Header"><Font ss:Bold="1"/></Style></Styles><Worksheet ss:Name="Reintegros"><Table>';
        $html .= '<Row><Cell ss:StyleID="Header"><Data ss:Type="String">ID Reintegro</Data></Cell><Cell ss:StyleID="Header"><Data ss:Type="String">ID Accidente</Data></Cell><Cell ss:StyleID="Header"><Data ss:Type="String">Alumno</Data></Cell><Cell ss:StyleID="Header"><Data ss:Type="String">Escuela</Data></Cell><Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Solicitud</Data></Cell><Cell ss:StyleID="Header"><Data ss:Type="String">Monto Solicitado</Data></Cell><Cell ss:StyleID="Header"><Data ss:Type="String">Estado</Data></Cell></Row>';

        foreach ($reintegros as $reintegro) {
            $html .= '<Row>';
            $html .= '<Cell><Data ss:Type="Number">' . $reintegro->id_reintegro . '</Data></Cell>';
            $html .= '<Cell><Data ss:Type="String">' . export_clean($reintegro->accidente->id_accidente_entero ?? 'N/A') . '</Data></Cell>';
            $html .= '<Cell><Data ss:Type="String">' . export_clean($reintegro->alumno->nombre_completo ?? 'N/A') . '</Data></Cell>';
            $html .= '<Cell><Data ss:Type="String">' . export_clean($reintegro->accidente->escuela->nombre ?? 'N/A') . '</Data></Cell>';
            $html .= '<Cell><Data ss:Type="String">' . ($reintegro->fecha_solicitud ? $reintegro->fecha_solicitud->format('d/m/Y') : '') . '</Data></Cell>';
            $html .= '<Cell><Data ss:Type="Number">' . $reintegro->monto_solicitado . '</Data></Cell>';
            $html .= '<Cell><Data ss:Type="String">' . export_clean($reintegro->estadoReintegro->descripcion ?? 'Sin Estado') . '</Data></Cell>';
            $html .= '</Row>';
        }

        $html .= '</Table></Worksheet></Workbook>';
        return $html;
    }

    public function exportarPDF(Request $request)
    {
        $reintegros = $this->getReintegrosQuery($request)->get();
        AuditoriaService::registrarConsulta('reintegros_export_pdf', $request->all());
        // Asumiendo que existe una vista para el PDF
        return view('exports.reintegros_pdf', compact('reintegros'));
    }

    private function getReintegrosQuery(Request $request)
    {
        $query = Reintegro::query()->with(['accidente', 'alumno', 'estadoReintegro', 'accidente.escuela']);
        
        if ($request->filled('filtro_id_accidente')) {
            $query->whereHas('accidente', function($q) use ($request) {
                $q->where('id_accidente_entero', 'like', '%' . $request->filtro_id_accidente . '%');
            });
        }
        
        if ($request->filled('filtro_fecha_solicitud')) {
            $query->whereDate('fecha_solicitud', '=', $request->filtro_fecha_solicitud);
        }

        if ($request->filled('filtro_estado')) {
            $query->where('id_estado_reintegro', $request->filtro_estado);
        }

        $usuario = Auth::user();
        if ($usuario && $usuario->id_rol == 1 && $usuario->id_escuela) {
            $query->whereHas('accidente', function ($q) use ($usuario) {
                $q->where('id_escuela', $usuario->id_escuela);
            });
        } else {
            if ($request->filled('filtro_escuela')) {
                $query->whereHas('accidente.escuela', function($q) use ($request) {
                    $q->where('id_escuela', $request->filtro_escuela);
                });
            }
        }

        return $query->orderBy('id_reintegro', 'desc');
    }
}
