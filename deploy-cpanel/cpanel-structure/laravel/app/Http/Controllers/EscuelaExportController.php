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
                'Nombre de Escuela',
                'CUIT',
                'Estatus',
                'Teléfono',
                'Correo',
                'Domicilio',
                'Alumnos',
                'Empleados',
                'Salidas Educativas',
                'Pasantías',
                'Beneficiarios SVO',
                'Accidentes',
            ], ',', '"');

            foreach ($entidades as $entidad) {
                fputcsv($file, [
                    $entidad->nombre,
                    $entidad->codigo_escuela,
                    $entidad->activo ? 'Activo' : 'Inactivo',
                    $entidad->telefono ?? 'No disponible',
                    $entidad->email ?? 'No disponible',
                    $entidad->direccion ?? 'No disponible',
                    $entidad->cantidad_alumnos ?? 0,
                    $entidad->cantidad_empleados ?? 0,
                    $entidad->salidas_educativas_count ?? 0,
                    $entidad->pasantias_count ?? 0,
                    $entidad->beneficiarios_svo_count ?? 0,
                    $entidad->accidentes_count ?? 0,
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
        $query = Escuela::query()
            ->withCount([
                'accidentes',
                'salidasEducativas',
                'pasantias',
                'beneficiariosSvo'
            ]);

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
            <Cell ss:StyleID="Header"><Data ss:Type="String">Nombre de Escuela</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">CUIT</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Estatus</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Teléfono</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Correo</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Domicilio</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Alumnos</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Empleados</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Salidas Educativas</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Pasantías</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Beneficiarios SVO</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Accidentes</Data></Cell>
           </Row>';

       foreach ($entidades as $entidad) {
           $html .= '<Row>
            <Cell><Data ss:Type="String">' . export_clean($entidad->nombre) . '</Data></Cell>
            <Cell><Data ss:Type="String">' . export_clean($entidad->codigo_escuela) . '</Data></Cell>
            <Cell><Data ss:Type="String">' . ($entidad->activo ? 'Activo' : 'Inactivo') . '</Data></Cell>
            <Cell><Data ss:Type="String">' . export_clean($entidad->telefono ?? 'No disponible') . '</Data></Cell>
            <Cell><Data ss:Type="String">' . export_clean($entidad->email ?? 'No disponible') . '</Data></Cell>
            <Cell><Data ss:Type="String">' . export_clean($entidad->direccion ?? 'No disponible') . '</Data></Cell>
            <Cell><Data ss:Type="Number">' . ($entidad->cantidad_alumnos ?? 0) . '</Data></Cell>
            <Cell><Data ss:Type="Number">' . ($entidad->cantidad_empleados ?? 0) . '</Data></Cell>
            <Cell><Data ss:Type="Number">' . ($entidad->salidas_educativas_count ?? 0) . '</Data></Cell>
            <Cell><Data ss:Type="Number">' . ($entidad->pasantias_count ?? 0) . '</Data></Cell>
            <Cell><Data ss:Type="Number">' . ($entidad->beneficiarios_svo_count ?? 0) . '</Data></Cell>
            <Cell><Data ss:Type="Number">' . ($entidad->accidentes_count ?? 0) . '</Data></Cell>
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
                        <th>Nombre de Escuela</th>
                        <th>CUIT</th>
                        <th>Estatus</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Domicilio</th>
                        <th>Alumnos</th>
                        <th>Empleados</th>
                        <th>Salidas Educativas</th>
                        <th>Pasantías</th>
                        <th>Beneficiarios SVO</th>
                        <th>Accidentes</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($entidades as $entidad) {
            $html .= '<tr>
                <td>' . htmlspecialchars($entidad->nombre) . '</td>
                <td>' . htmlspecialchars($entidad->codigo_escuela) . '</td>
                <td>' . ($entidad->activo ? 'Activo' : 'Inactivo') . '</td>
                <td>' . htmlspecialchars($entidad->telefono ?? 'No disponible') . '</td>
                <td>' . htmlspecialchars($entidad->email ?? 'No disponible') . '</td>
                <td>' . htmlspecialchars($entidad->direccion ?? 'No disponible') . '</td>
                <td>' . ($entidad->cantidad_alumnos ?? 0) . '</td>
                <td>' . ($entidad->cantidad_empleados ?? 0) . '</td>
                <td>' . ($entidad->salidas_educativas_count ?? 0) . '</td>
                <td>' . ($entidad->pasantias_count ?? 0) . '</td>
                <td>' . ($entidad->beneficiarios_svo_count ?? 0) . '</td>
                <td>' . ($entidad->accidentes_count ?? 0) . '</td>
            </tr>';
        }

        $html .= '</tbody>
            </table>
        </body>
        </html>';

        return $html;
    }
}
