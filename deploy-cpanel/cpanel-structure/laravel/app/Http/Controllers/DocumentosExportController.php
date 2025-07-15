<?php

namespace App\Http\Controllers;

use App\Models\DocumentoInstitucional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class DocumentosExportController extends Controller
{
    public function exportarCSV(Request $request)
    {
        $documentos = $this->getEntidadesFiltradas($request);
        $filename = 'documentos_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($documentos) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, [
                'ID',
                'Nombre Documento',
                'Escuela',
                'Tipo Documento',
                'Fecha Documento',
                'Fecha Vencimiento',
                'Usuario Carga',
                'Fecha Carga',
            ], ',', '"');

            foreach ($documentos as $doc) {
                fputcsv($file, [
                    $doc->id_documento,
                    $doc->nombre_documento,
                    $doc->escuela->nombre ?? 'N/A',
                    $doc->tipoDocumento->nombre ?? 'N/A',
                    $doc->fecha_documento ? $doc->fecha_documento->format('d/m/Y') : 'N/A',
                    $doc->fecha_vencimiento ? $doc->fecha_vencimiento->format('d/m/Y') : 'N/A',
                    $doc->usuarioCarga->nombre_completo ?? 'N/A',
                    $doc->fecha_carga ? $doc->fecha_carga->format('d/m/Y H:i') : 'N/A',
                ], ',', '"');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportarExcel(Request $request)
    {
        $documentos = $this->getEntidadesFiltradas($request);
        $filename = 'documentos_' . date('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $html = $this->generarHTMLParaExcel($documentos);
        return Response::make($html, 200, $headers);
    }

    public function exportarPDF(Request $request)
    {
        $documentos = $this->getEntidadesFiltradas($request);
        $html = $this->generarHTMLParaPDF($documentos);
        
        $headers = [
            'Content-Type' => 'text/html; charset=UTF-8',
        ];

        return Response::make($html, 200, $headers);
    }

    private function getEntidadesFiltradas(Request $request)
    {
        $query = DocumentoInstitucional::query()
            ->with(['escuela', 'tipoDocumento', 'usuarioCarga'])
            ->when($request->filtro_nombre, function ($query, $nombre) {
                $query->where('nombre_documento', 'like', '%' . $nombre . '%');
            })
            ->when($request->filtro_tipo_documento, function ($query, $tipo) {
                $query->where('id_tipo_documento', $tipo);
            })
            ->when($request->filtro_fecha_desde, function ($query, $fecha) {
                $query->whereDate('fecha_vencimiento', '>=', $fecha);
            })
            ->when($request->filtro_fecha_hasta, function ($query, $fecha) {
                $query->whereDate('fecha_vencimiento', '<=', $fecha);
            });

        $usuario = Auth::user();
        if ($usuario && $usuario->id_rol == 1 && $usuario->id_escuela) {
            $query->where('id_escuela', $usuario->id_escuela);
        }

        return $query->orderBy('nombre_documento', 'asc')->get();
    }

    private function generarHTMLParaExcel($documentos)
    {
        $html = '<?xml version="1.0" encoding="UTF-8"?>
        <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">
         <Styles>
          <Style ss:ID="Header"><Font ss:Bold="1"/></Style>
         </Styles>
         <Worksheet ss:Name="Documentos">
          <Table>
           <Row>
            <Cell ss:StyleID="Header"><Data ss:Type="String">ID</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Nombre Documento</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Escuela</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Tipo Documento</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Documento</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Vencimiento</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Usuario Carga</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Carga</Data></Cell>
           </Row>';

        foreach ($documentos as $doc) {
            $html .= '<Row>
             <Cell><Data ss:Type="Number">' . $doc->id_documento . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($doc->nombre_documento) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($doc->escuela->nombre ?? 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($doc->tipoDocumento->nombre ?? 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . ($doc->fecha_documento ? $doc->fecha_documento->format('d/m/Y') : 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . ($doc->fecha_vencimiento ? $doc->fecha_vencimiento->format('d/m/Y') : 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($doc->usuarioCarga->nombre_completo ?? 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . ($doc->fecha_carga ? $doc->fecha_carga->format('d/m/Y H:i') : 'N/A') . '</Data></Cell>
            </Row>';
        }

        $html .= '  </Table>
         </Worksheet>
        </Workbook>';

        return $html;
    }

    private function generarHTMLParaPDF($documentos)
    {
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Documentos Institucionales</title>
            <style>
                body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; }
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
                <h1>Reporte de Documentos Institucionales</h1>
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
                        <th>Nombre Documento</th>
                        <th>Escuela</th>
                        <th>Tipo</th>
                        <th>Fecha Doc.</th>
                        <th>Fecha Venc.</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($documentos as $doc) {
            $html .= '<tr>
                <td>' . $doc->id_documento . '</td>
                <td>' . htmlspecialchars($doc->nombre_documento) . '</td>
                <td>' . htmlspecialchars($doc->escuela->nombre ?? 'N/A') . '</td>
                <td>' . htmlspecialchars($doc->tipoDocumento->nombre ?? 'N/A') . '</td>
                <td>' . ($doc->fecha_documento ? $doc->fecha_documento->format('d/m/Y') : 'N/A') . '</td>
                <td>' . ($doc->fecha_vencimiento ? $doc->fecha_vencimiento->format('d/m/Y') : 'N/A') . '</td>
            </tr>';
        }

        $html .= '</tbody>
            </table>
            
            <div class="footer">
                <p>Total de registros: ' . count($documentos) . '</p>
                <p>Sistema Fondo Solidario - ' . date('Y') . '</p>
            </div>
        </body>
        </html>';

        return $html;
    }
}
