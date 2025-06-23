<?php

namespace App\Http\Controllers;

use App\Models\Derivacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class DerivacionesExportController extends Controller
{
    public function exportarCSV(Request $request)
    {
        $entidades = $this->getEntidadesFiltradas($request);
        
        $filename = 'derivaciones_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($entidades) {
            $file = fopen('php://output', 'w');
            
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, [
                'ID Derivacion',
                'ID Accidente',
                'Alumno',
                'Escuela',
                'Prestador',
                'Fecha Derivacion',
                'Hora Derivacion',
                'Medico que Deriva',
                'Diagnostico Inicial',
                'Acompanante',
                'Impresa',
                'Fecha Impresion'
            ], ',', '"');

            foreach ($entidades as $entidad) {
                fputcsv($file, [
                    $entidad->id_derivacion,
                    $entidad->id_accidente,
                    export_clean($entidad->alumno->nombre_completo ?? 'N/A'),
                    export_clean($entidad->accidente->escuela->nombre ?? 'N/A'),
                    export_clean($entidad->prestador->nombre ?? 'N/A'),
                    $entidad->fecha_derivacion->format('d/m/Y'),
                    \Carbon\Carbon::parse($entidad->hora_derivacion)->format('h:i A'),
                    export_clean($entidad->medico_deriva),
                    export_clean($entidad->diagnostico_inicial),
                    export_clean($entidad->acompanante),
                    $entidad->impresa ? 'Si' : 'No',
                    $entidad->fecha_impresion ? $entidad->fecha_impresion->format('d/m/Y H:i') : 'N/A'
                ], ',', '"');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportarExcel(Request $request)
    {
        $entidades = $this->getEntidadesFiltradas($request);
        
        $filename = 'derivaciones_' . date('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $html = $this->generarHTMLParaExcel($entidades);

        return Response::make($html, 200, $headers);
    }

    public function exportarPDF(Request $request)
    {
        $entidades = $this->getEntidadesFiltradas($request);
        
        $html = $this->generarHTMLParaPDF($entidades);
        
        $headers = [
            'Content-Type' => 'text/html; charset=UTF-8',
        ];

        return Response::make($html, 200, $headers);
    }

    private function getEntidadesFiltradas(Request $request)
    {
        $query = Derivacion::query()
            ->with(['accidente.escuela', 'prestador', 'alumno']);

        $usuario = Auth::user();
        if ($usuario->id_rol == 1 && $usuario->id_escuela) {
            $query->whereHas('accidente', function($q) use ($usuario) {
                $q->where('id_escuela', $usuario->id_escuela);
            });
        }

        $query->when($request->filtro_accidente, function ($query, $filtro) {
                $query->where('id_accidente', 'like', '%' . $filtro . '%');
            })
            ->when($request->filtro_prestador, function ($query, $filtro) {
                $query->where('id_prestador', $filtro);
            })
            ->when($request->filtro_fecha_derivacion, function ($query, $filtro) {
                $query->where('fecha_derivacion', $filtro);
            })
            ->when($request->filtro_escuela, function ($query, $filtro) {
                $query->whereHas('accidente.escuela', function ($q) use ($filtro) {
                    $q->where('id_escuela', $filtro);
                });
            })
            ->when($request->filtro_impresa !== null && $request->filtro_impresa !== '', function ($query) use ($request) {
                $impresa = $request->filtro_impresa === 'si';
                $query->where('impresa', $impresa);
            });

        return $query->orderBy('id_derivacion', 'desc')->get();
    }

    private function generarHTMLParaExcel($entidades)
    {
        $html = '<?xml version="1.0" encoding="UTF-8"?>
        <?mso-application progid="Excel.Sheet"?>
        <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:o="urn:schemas-microsoft-com:office:office"
         xmlns:x="urn:schemas-microsoft-com:office:excel"
         xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:html="http://www.w3.org/TR/REC-html40">
         <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
          <Title>Reporte de Derivaciones</Title>
          <Author>Sistema Fondo Solidario</Author>
          <Created>' . date('Y-m-d\TH:i:s\Z') . '</Created>
         </DocumentProperties>
         <Styles>
          <Style ss:ID="Header">
           <Font ss:Bold="1"/>
           <Interior ss:Color="#CCCCCC" ss:Pattern="Solid"/>
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
           </Borders>
          </Style>
          <Style ss:ID="Data">
           <Borders>
            <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
           </Borders>
          </Style>
         </Styles>
         <Worksheet ss:Name="Derivaciones">
          <Table>
           <Row>
            <Cell ss:StyleID="Header"><Data ss:Type="String">ID Derivacion</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">ID Accidente</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Alumno</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Escuela</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Prestador</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Derivacion</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Impresa</Data></Cell>
           </Row>';

        foreach ($entidades as $entidad) {
            $html .= '<Row>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($entidad->id_derivacion) . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($entidad->id_accidente) . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($entidad->alumno->nombre_completo ?? 'N/A') . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($entidad->accidente->escuela->nombre ?? 'N/A') . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($entidad->prestador->nombre ?? 'N/A') . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . $entidad->fecha_derivacion->format('d/m/Y') . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean(($entidad->impresa ? 'Si' : 'No')) . '</Data></Cell>
            </Row>';
        }

        $html .= '  </Table>
         </Worksheet>
        </Workbook>';

        return $html;
    }

    private function generarHTMLParaPDF($entidades)
    {
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Derivaciones</title>
            <style>
                body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 11px; }
                th { background-color: #f2f2f2; font-weight: bold; }
                .header { text-align: center; margin-bottom: 20px; }
                .fecha { text-align: right; margin-bottom: 10px; font-size: 10px; }
                .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #666; }
                @media print { body { margin: 0; } .no-print { display: none; } }
            </style>
        </head>
        <body>
            <div class="fecha">Generado el: ' . date('d/m/Y H:i') . '</div>
            <div class="header">
                <h1>Reporte de Derivaciones</h1>
                <p>Sistema Fondo Solidario</p>
            </div>
            
            <div class="no-print" style="margin-bottom: 20px; text-align: center;">
                <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    🖨️ Imprimir / Guardar como PDF
                </button>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Alumno</th>
                        <th>Escuela</th>
                        <th>Prestador</th>
                        <th>Fecha</th>
                        <th>Impresa</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($entidades as $entidad) {
            $html .= '<tr>
                <td>' . export_clean($entidad->id_derivacion) . '</td>
                <td>' . export_clean($entidad->alumno->nombre_completo ?? 'N/A') . '</td>
                <td>' . export_clean($entidad->accidente->escuela->nombre ?? 'N/A') . '</td>
                <td>' . export_clean($entidad->prestador->nombre ?? 'N/A') . '</td>
                <td>' . $entidad->fecha_derivacion->format('d/m/Y') . '</td>
                <td>' . export_clean(($entidad->impresa ? 'Si' : 'No')) . '</td>
            </tr>';
        }

        $html .= '</tbody>
            </table>
            
            <div class="footer">
                <p>Total de registros: ' . count($entidades) . '</p>
                <p>Sistema Fondo Solidario - ' . date('Y') . '</p>
            </div>
        </body>
        </html>';

        return $html;
    }
}
