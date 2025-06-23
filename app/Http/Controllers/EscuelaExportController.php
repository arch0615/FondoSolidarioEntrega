<?php

namespace App\Http\Controllers;

use App\Models\Escuela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class EscuelaExportController extends Controller
{
    public function exportarCSV(Request $request)
    {
        $entidades = $this->getEntidadesFiltradas($request);
        
        $filename = 'escuelas_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($entidades) {
            $file = fopen('php://output', 'w');
            
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, [
                'ID',
                'Código',
                'Nombre',
                'Dirección',
                'Teléfono',
                'Email',
                'Aporte por Alumno',
                'Fecha Alta',
                'Estado',
            ], ',', '"');

            foreach ($entidades as $entidad) {
                fputcsv($file, [
                    $entidad->id_escuela,
                    $entidad->codigo_escuela,
                    $entidad->nombre,
                    $entidad->direccion,
                    $entidad->telefono,
                    $entidad->email,
                    $entidad->aporte_por_alumno,
                    $entidad->fecha_alta ? $entidad->fecha_alta->format('d/m/Y') : 'N/A',
                    $entidad->activo ? 'Activo' : 'Inactivo',
                ], ',', '"');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportarExcel(Request $request)
    {
        $entidades = $this->getEntidadesFiltradas($request);
        $filename = 'escuelas_' . date('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
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
        $query = Escuela::query();

        if ($request->has('filtro_nombre') && $request->filtro_nombre) {
            $query->where('nombre', 'like', '%' . $request->filtro_nombre . '%');
        }

        if ($request->has('filtro_codigo') && $request->filtro_codigo) {
            $query->where('codigo_escuela', 'like', '%' . $request->filtro_codigo . '%');
        }

        if ($request->has('filtro_estado') && $request->filtro_estado !== '') {
            $activo = $request->filtro_estado === 'activo';
            $query->where('activo', $activo);
        }

        return $query->orderBy('nombre', 'asc')->get();
    }

    private function generarHTMLParaExcel($entidades)
    {
        $html = '<?xml version="1.0" encoding="UTF-8"?>
        <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">
         <Styles>
          <Style ss:ID="Header"><Font ss:Bold="1"/></Style>
         </Styles>
         <Worksheet ss:Name="Escuelas">
          <Table>
           <Row>
            <Cell ss:StyleID="Header"><Data ss:Type="String">ID</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Código</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Nombre</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Dirección</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Teléfono</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Email</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Aporte</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Alta</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Estado</Data></Cell>
           </Row>';

        foreach ($entidades as $entidad) {
            $html .= '<Row>
             <Cell><Data ss:Type="Number">' . $entidad->id_escuela . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->codigo_escuela) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->nombre) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->direccion) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->telefono) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->email) . '</Data></Cell>
             <Cell><Data ss:Type="Number">' . $entidad->aporte_por_alumno . '</Data></Cell>
             <Cell><Data ss:Type="String">' . ($entidad->fecha_alta ? $entidad->fecha_alta->format('d/m/Y') : 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . ($entidad->activo ? 'Activo' : 'Inactivo') . '</Data></Cell>
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
            <title>Reporte de Escuelas</title>
            <style>
                body { font-family: Arial, sans-serif; font-size: 12px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .header { text-align: center; margin-bottom: 20px; }
                .no-print { display: none; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Reporte de Escuelas</h1>
                <p>Sistema Fondo Solidario</p>
            </div>
            <button onclick="window.print()" class="no-print">Imprimir</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($entidades as $entidad) {
            $html .= '<tr>
                <td>' . $entidad->id_escuela . '</td>
                <td>' . htmlspecialchars($entidad->codigo_escuela) . '</td>
                <td>' . htmlspecialchars($entidad->nombre) . '</td>
                <td>' . htmlspecialchars($entidad->telefono) . '</td>
                <td>' . ($entidad->activo ? 'Activo' : 'Inactivo') . '</td>
            </tr>';
        }

        $html .= '</tbody>
            </table>
        </body>
        </html>';

        return $html;
    }
}
