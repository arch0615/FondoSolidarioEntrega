<?php

namespace App\Http\Controllers;

use App\Models\Prestador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class PrestadorExportController extends Controller
{
    public function exportarCSV(Request $request)
    {
        $entidades = $this->getEntidadesFiltradas($request);
        
        $filename = 'prestadores_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($entidades) {
            $file = fopen('php://output', 'w');
            
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, [
                'Nombre',
                'Tipo',
                'Dirección',
                'Teléfono',
                'Email',
                'Especialidades',
                'Sistema Emergencias',
                'Estado',
            ], ',', '"');

            foreach ($entidades as $entidad) {
                fputcsv($file, [
                    $entidad->nombre,
                    $entidad->tipoPrestador->descripcion ?? 'N/A',
                    $entidad->direccion,
                    $entidad->telefono,
                    $entidad->email,
                    $entidad->especialidades,
                    $entidad->es_sistema_emergencias ? 'Sí' : 'No',
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
        $filename = 'prestadores_' . date('Y-m-d_H-i-s') . '.xls';
        
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
        $query = Prestador::query()
            ->with('tipoPrestador')
            ->when($request->filtro_nombre, function ($query, $nombre) {
                $query->where('nombre', 'like', '%' . $nombre . '%');
            })
            ->when($request->filtro_tipo, function ($query, $tipo) {
                $query->where('id_tipo_prestador', $tipo);
            })
            ->when($request->filtro_especialidad, function ($query, $especialidad) {
                $query->where('especialidades', 'like', '%' . $especialidad . '%');
            })
            ->when($request->filtro_estado !== null && $request->filtro_estado !== '', function ($query) use ($request) {
                $activo = $request->filtro_estado === 'activo';
                $query->where('activo', $activo);
            });

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
         <Worksheet ss:Name="Prestadores">
          <Table>
           <Row>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Nombre</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Tipo</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Dirección</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Teléfono</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Email</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Especialidades</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Sistema Emergencias</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Estado</Data></Cell>
           </Row>';

        foreach ($entidades as $entidad) {
            $html .= '<Row>
             <Cell><Data ss:Type="String">' . export_clean($entidad->nombre) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->tipoPrestador->descripcion ?? 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->direccion) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->telefono) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->email) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->especialidades) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . ($entidad->es_sistema_emergencias ? 'Sí' : 'No') . '</Data></Cell>
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
            <title>Reporte de Prestadores</title>
            <style>
                body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; word-break: break-word; }
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
                <h1>Reporte de Prestadores</h1>
                <p>Sistema de Fondo Solidario</p>
            </div>
            
            <div class="no-print" style="margin-bottom: 20px; text-align: center;">
                <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    🖨️ Imprimir / Guardar como PDF
                </button>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Especialidades</th>
                        <th>Emergencias</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($entidades as $entidad) {
            $html .= '<tr>
                <td>' . htmlspecialchars($entidad->nombre) . '</td>
                <td>' . htmlspecialchars($entidad->tipoPrestador->descripcion ?? 'N/A') . '</td>
                <td>' . htmlspecialchars($entidad->direccion) . '</td>
                <td>' . htmlspecialchars($entidad->telefono) . '</td>
                <td>' . htmlspecialchars($entidad->email) . '</td>
                <td>' . htmlspecialchars($entidad->especialidades) . '</td>
                <td>' . ($entidad->es_sistema_emergencias ? 'Sí' : 'No') . '</td>
                <td>' . ($entidad->activo ? 'Activo' : 'Inactivo') . '</td>
            </tr>';
        }

        $html .= '</tbody>
            </table>
            
            <div class="footer">
                <p>Total de registros: ' . count($entidades) . '</p>
                <p>Sistema de Fondo Solidario - ' . date('Y') . '</p>
            </div>
        </body>
        </html>';

        return $html;
    }
}
