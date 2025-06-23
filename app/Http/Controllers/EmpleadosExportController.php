<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class EmpleadosExportController extends Controller
{
    public function exportarCSV(Request $request)
    {
        $entidades = $this->getEntidadesFiltradas($request);
        
        $filename = 'empleados_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($entidades) {
            $file = fopen('php://output', 'w');
            
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, [
                'Nombre', 'Apellido', 'DNI', 'CUIL', 'Cargo', 'Fecha Ingreso', 'Fecha Egreso', 'Teléfono', 'Email', 'Dirección', 'Escuela', 'Estado'
            ], ',', '"');

            foreach ($entidades as $entidad) {
                fputcsv($file, [
                    export_clean($entidad->nombre),
                    export_clean($entidad->apellido),
                    export_clean($entidad->dni),
                    export_clean($entidad->cuil),
                    export_clean($entidad->cargo),
                    $entidad->fecha_ingreso ? $entidad->fecha_ingreso->format('d/m/Y') : 'N/A',
                    $entidad->fecha_egreso ? $entidad->fecha_egreso->format('d/m/Y') : 'N/A',
                    export_clean($entidad->telefono),
                    export_clean($entidad->email),
                    export_clean($entidad->direccion),
                    export_clean($entidad->escuela->nombre ?? 'N/A'),
                    export_clean($entidad->activo ? 'Activo' : 'Inactivo'),
                ], ',', '"');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportarExcel(Request $request)
    {
        $entidades = $this->getEntidadesFiltradas($request);
        
        $filename = 'empleados_' . date('Y-m-d_H-i-s') . '.xls';
        
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
        $query = Empleado::query()->with('escuela');

        $usuario = Auth::user();

        if ($usuario && $usuario->id_rol == 1) {
            $query->where('id_escuela', $usuario->id_escuela);
        } else {
            if ($request->has('filtro_escuela') && $request->filtro_escuela) {
                $query->where('id_escuela', $request->filtro_escuela);
            }
        }

        if ($request->has('filtro_nombre') && $request->filtro_nombre) {
            $query->where('nombre', 'like', '%' . $request->filtro_nombre . '%');
        }
        if ($request->has('filtro_apellido') && $request->filtro_apellido) {
            $query->where('apellido', 'like', '%' . $request->filtro_apellido . '%');
        }
        if ($request->has('filtro_dni') && $request->filtro_dni) {
            $query->where('dni', 'like', '%' . $request->filtro_dni . '%');
        }
        if ($request->has('filtro_estado') && $request->filtro_estado !== '') {
            $activo = $request->filtro_estado === 'activo';
            $query->where('activo', $activo);
        }

        return $query->orderBy('apellido', 'asc')->get();
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
          <Title>Reporte de Empleados</Title>
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
         <Worksheet ss:Name="Empleados">
          <Table>
           <Row>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Nombre</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Apellido</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">DNI</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">CUIL</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Cargo</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Ingreso</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Egreso</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Teléfono</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Email</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Dirección</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Escuela</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Estado</Data></Cell>
           </Row>';

        foreach ($entidades as $entidad) {
            $html .= '<Row>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($entidad->nombre) . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($entidad->apellido) . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($entidad->dni) . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($entidad->cuil) . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($entidad->cargo) . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . ($entidad->fecha_ingreso ? $entidad->fecha_ingreso->format('d/m/Y') : 'N/A') . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . ($entidad->fecha_egreso ? $entidad->fecha_egreso->format('d/m/Y') : 'N/A') . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($entidad->telefono) . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($entidad->email) . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($entidad->direccion) . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean($entidad->escuela->nombre ?? 'N/A') . '</Data></Cell>
             <Cell ss:StyleID="Data"><Data ss:Type="String">' . export_clean(($entidad->activo ? 'Activo' : 'Inactivo')) . '</Data></Cell>
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
            <title>Reporte de Empleados</title>
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
                <h1>Reporte de Empleados</h1>
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
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>CUIL</th>
                        <th>Cargo</th>
                        <th>F. Ingreso</th>
                        <th>F. Egreso</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Escuela</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($entidades as $entidad) {
            $html .= '<tr>
                <td>' . export_clean($entidad->nombre) . '</td>
                <td>' . export_clean($entidad->apellido) . '</td>
                <td>' . export_clean($entidad->dni) . '</td>
                <td>' . export_clean($entidad->cuil) . '</td>
                <td>' . export_clean($entidad->cargo) . '</td>
                <td>' . ($entidad->fecha_ingreso ? $entidad->fecha_ingreso->format('d/m/Y') : 'N/A') . '</td>
                <td>' . ($entidad->fecha_egreso ? $entidad->fecha_egreso->format('d/m/Y') : 'N/A') . '</td>
                <td>' . export_clean($entidad->telefono) . '</td>
                <td>' . export_clean($entidad->email) . '</td>
                <td>' . export_clean($entidad->direccion) . '</td>
                <td>' . export_clean($entidad->escuela->nombre ?? 'N/A') . '</td>
                <td>' . export_clean(($entidad->activo ? 'Activo' : 'Inactivo')) . '</td>
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
