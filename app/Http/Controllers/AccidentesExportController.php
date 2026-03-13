<?php

namespace App\Http\Controllers;

use App\Models\Accidente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class AccidentesExportController extends Controller
{
    public function exportarCSV(Request $request)
    {
        $accidentes = $this->getAccidentesFiltrados($request);
        
        $filename = 'accidentes_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($accidentes) {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Encabezados usando fputcsv estándar con comas
            fputcsv($file, [
                'N° Expediente',
                'Escuela',
                'Fecha Accidente',
                'Hora Accidente',
                'Lugar',
                'Tipo Lesión',
                'Alumnos Involucrados',
                'Protocolo Activado',
                'Estado',
                'Fecha Carga'
            ], ',', '"');

            // Datos
            foreach ($accidentes as $accidente) {
                fputcsv($file, [
                    export_clean($accidente->numero_expediente),
                    export_clean($accidente->escuela->nombre ?? 'Sin escuela'),
                    $accidente->fecha_accidente->format('d/m/Y'),
                    $accidente->hora_accidente ? $accidente->hora_accidente->format('H:i') : 'N/A',
                    export_clean($accidente->lugar_accidente),
                    export_clean($accidente->tipo_lesion),
                    $accidente->alumnos->count(),
                    $accidente->protocolo_activado ? 'Sí' : 'No',
                    export_clean($accidente->estado->nombre_estado ?? 'Sin estado'),
                    $accidente->fecha_carga ? $accidente->fecha_carga->format('d/m/Y H:i') : 'N/A'
                ], ',', '"');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportarExcel(Request $request)
    {
        $accidentes = $this->getAccidentesFiltrados($request);
        
        $filename = 'accidentes_' . date('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $html = $this->generarHTMLParaExcel($accidentes);

        return Response::make($html, 200, $headers);
    }

    public function exportarPDF(Request $request)
    {
        $accidentes = $this->getAccidentesFiltrados($request);
        
        $html = $this->generarHTMLParaPDF($accidentes);
        
        $headers = [
            'Content-Type' => 'text/html; charset=UTF-8',
        ];

        return Response::make($html, 200, $headers);
    }

    private function getAccidentesFiltrados(Request $request)
    {
        $query = Accidente::query()
            ->with([
                'escuela',
                'estado',
                'alumnos.alumno'
            ]);

        // Aplicar filtros si existen
        if ($request->has('filtro_escuela') && $request->filtro_escuela) {
            $query->where('id_escuela', $request->filtro_escuela);
        }

        if ($request->has('filtro_fecha') && $request->filtro_fecha) {
            $query->whereDate('fecha_accidente', $request->filtro_fecha);
        }

        if ($request->has('filtro_estado') && $request->filtro_estado) {
            $query->where('id_estado_accidente', $request->filtro_estado);
        }

        if ($request->has('filtro_expediente') && $request->filtro_expediente) {
            $query->where('numero_expediente', 'like', '%' . $request->filtro_expediente . '%');
        }

        // Aplicar filtro por escuela del usuario si es usuario general
        $usuario = Auth::user();
        if ($usuario && $usuario->id_rol == 1 && $usuario->id_escuela) {
            $query->where('id_escuela', $usuario->id_escuela);
        }

        return $query->orderBy('fecha_accidente', 'desc')->get();
    }

    private function generarHTMLParaPDF($accidentes)
    {
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Accidentes</title>
            <style>
                body { 
                    font-family: Arial, sans-serif; 
                    font-size: 12px; 
                    margin: 20px;
                }
                table { 
                    width: 100%; 
                    border-collapse: collapse; 
                    margin-top: 20px; 
                }
                th, td { 
                    border: 1px solid #ddd; 
                    padding: 8px; 
                    text-align: left; 
                    font-size: 11px;
                }
                th { 
                    background-color: #f2f2f2; 
                    font-weight: bold; 
                }
                .header { 
                    text-align: center; 
                    margin-bottom: 20px; 
                }
                .fecha { 
                    text-align: right; 
                    margin-bottom: 10px; 
                    font-size: 10px;
                }
                .footer {
                    margin-top: 30px; 
                    text-align: center; 
                    font-size: 10px; 
                    color: #666;
                }
                @media print {
                    body { margin: 0; }
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="fecha">Generado el: ' . date('d/m/Y H:i') . '</div>
            <div class="header">
                <h1>Reporte de Accidentes</h1>
                <p>Sistema Fondo Solidario JAEC</p>
            </div>
            
            <div class="no-print" style="margin-bottom: 20px; text-align: center;">
                <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    🖨️ Imprimir / Guardar como PDF
                </button>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>N° Expediente</th>
                        <th>Escuela</th>
                        <th>Fecha</th>
                        <th>Lugar</th>
                        <th>Tipo Lesión</th>
                        <th>Alumnos</th>
                        <th>Protocolo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($accidentes as $accidente) {
            $html .= '<tr>
                <td>' . export_clean($accidente->numero_expediente) . '</td>
                <td>' . export_clean($accidente->escuela->nombre ?? 'Sin escuela') . '</td>
                <td>' . $accidente->fecha_accidente->format('d/m/Y') . '</td>
                <td>' . export_clean($accidente->lugar_accidente) . '</td>
                <td>' . export_clean($accidente->tipo_lesion) . '</td>
                <td>' . export_clean($accidente->alumnos->count() . ' alumno(s)') . '</td>
                <td>' . export_clean(($accidente->protocolo_activado ? 'Sí' : 'No')) . '</td>
                <td>' . export_clean($accidente->estado->nombre_estado ?? 'Sin estado') . '</td>
            </tr>';
        }

        $html .= '</tbody>
            </table>
            
            <div class="footer">
                <p>Total de registros: ' . count($accidentes) . '</p>
                <p>Sistema Fondo Solidario JAEC - ' . date('Y') . '</p>
            </div>
        </body>
        </html>';

        return $html;
    }

    private function generarHTMLParaExcel($accidentes)
    {
        $html = '<?xml version="1.0" encoding="UTF-8"?>
        <?mso-application progid="Excel.Sheet"?>
        <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:o="urn:schemas-microsoft-com:office:office"
         xmlns:x="urn:schemas-microsoft-com:office:excel"
         xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:html="http://www.w3.org/TR/REC-html40">
         <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
          <Title>Reporte de Accidentes</Title>
          <Author>Sistema Fondo Solidario JAEC</Author>
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
         <Worksheet ss:Name="Accidentes">
          <Table>
           <Row>
            <Cell ss:StyleID="Header"><Data ss:Type="String">N° Expediente</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Escuela</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Accidente</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Hora Accidente</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Lugar</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Tipo Lesión</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Alumnos Involucrados</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Protocolo Activado</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Estado</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Carga</Data></Cell>
           </Row>';

        foreach ($accidentes as $accidente) {
            $html .= '<Row>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($accidente->numero_expediente) . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($accidente->escuela->nombre ?? 'Sin escuela') . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . $accidente->fecha_accidente->format('d/m/Y') . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . ($accidente->hora_accidente ? $accidente->hora_accidente->format('H:i') : 'N/A') . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($accidente->lugar_accidente) . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($accidente->tipo_lesion) . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="Number">' . $accidente->alumnos->count() . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . ($accidente->protocolo_activado ? 'Sí' : 'No') . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($accidente->estado->nombre_estado ?? 'Sin estado') . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . ($accidente->fecha_carga ? $accidente->fecha_carga->format('d/m/Y H:i') : 'N/A') . '</Data></Cell>
            </Row>';
        }

        $html .= '  </Table>
         </Worksheet>
        </Workbook>';

        return $html;
    }
}