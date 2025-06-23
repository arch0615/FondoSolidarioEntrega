<?php

namespace App\Http\Controllers;

use App\Models\BeneficiarioSvo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class BeneficiarioSvoExportController extends Controller
{
    public function exportarCSV(Request $request)
    {
        $entidades = $this->getEntidadesFiltradas($request);
        $filename = 'beneficiarios_svo_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($entidades) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, [
                'Empleado Titular',
                'DNI Empleado',
                'Escuela',
                'Beneficiario',
                'DNI Beneficiario',
                'Parentesco',
                'Porcentaje',
                'Estado',
                'Fecha de Alta'
            ], ',', '"');

            foreach ($entidades as $entidad) {
                fputcsv($file, [
                    export_clean($entidad->empleado->nombre_completo ?? 'N/A'),
                    export_clean($entidad->empleado->dni ?? 'N/A'),
                    export_clean($entidad->escuela->nombre ?? 'N/A'),
                    export_clean($entidad->nombre . ' ' . $entidad->apellido),
                    export_clean($entidad->dni),
                    export_clean($entidad->parentesco->nombre_parentesco ?? 'N/A'),
                    export_clean($entidad->porcentaje . '%'),
                    export_clean($entidad->activo ? 'Activo' : 'Inactivo'),
                    $entidad->fecha_alta ? $entidad->fecha_alta->format('d/m/Y') : 'N/A'
                ], ',', '"');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportarExcel(Request $request)
    {
        $entidades = $this->getEntidadesFiltradas($request);
        $filename = 'beneficiarios_svo_' . date('Y-m-d_H-i-s') . '.xls';
        
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

    private function generarHTMLParaExcel($entidades)
    {
        $html = '<?xml version="1.0" encoding="UTF-8"?>
        <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:o="urn:schemas-microsoft-com:office:office"
         xmlns:x="urn:schemas-microsoft-com:office:excel"
         xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:html="http://www.w3.org/TR/REC-html40">
         <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
          <Title>Reporte de Beneficiarios SVO</Title>
          <Author>Sistema Fondo Solidario</Author>
          <Created>' . date('Y-m-d\TH:i:s\Z') . '</Created>
         </DocumentProperties>
         <Styles>
          <Style ss:ID="Header">
           <Font ss:Bold="1"/>
           <Interior ss:Color="#CCCCCC" ss:Pattern="Solid"/>
          </Style>
         </Styles>
         <Worksheet ss:Name="Beneficiarios">
          <Table>
           <Row>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Empleado Titular</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">DNI Empleado</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Escuela</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Beneficiario</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">DNI Beneficiario</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Parentesco</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Porcentaje</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Estado</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha de Alta</Data></Cell>
           </Row>';

        foreach ($entidades as $entidad) {
            $html .= '<Row>
             <Cell><Data ss:Type="String">' . export_clean($entidad->empleado->nombre_completo ?? 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->empleado->dni ?? 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->escuela->nombre ?? 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->nombre . ' ' . $entidad->apellido) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->dni) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->parentesco->nombre_parentesco ?? 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->porcentaje . '%') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($entidad->activo ? 'Activo' : 'Inactivo') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . ($entidad->fecha_alta ? $entidad->fecha_alta->format('d/m/Y') : 'N/A') . '</Data></Cell>
            </Row>';
        }

        $html .= '  </Table>
         </Worksheet>
        </Workbook>';

        return $html;
    }

    public function exportarPDF(Request $request)
    {
        $entidades = $this->getEntidadesFiltradas($request);
        $html = view('exports.beneficiarios_svo_pdf', ['beneficiarios' => $entidades])->render();
        
        $headers = [
            'Content-Type' => 'text/html; charset=UTF-8',
        ];

        return Response::make($html, 200, $headers);
    }

    private function getEntidadesFiltradas(Request $request)
    {
        $query = BeneficiarioSvo::query()
            ->with(['empleado', 'escuela', 'parentesco'])
            ->when($request->filtro_nombre, function ($query, $nombre) {
                $query->where(function ($q) use ($nombre) {
                    $q->where('beneficiarios_svo.nombre', 'like', '%' . $nombre . '%')
                      ->orWhere('beneficiarios_svo.apellido', 'like', '%' . $nombre . '%')
                      ->orWhereHas('empleado', function ($q) use ($nombre) {
                          $q->where('nombre', 'like', '%' . $nombre . '%')
                            ->orWhere('apellido', 'like', '%' . $nombre . '%');
                      });
                });
            })
            ->when($request->filtro_dni, function ($query, $dni) {
                $query->where('beneficiarios_svo.dni', 'like', '%' . $dni . '%')
                      ->orWhereHas('empleado', function ($q) use ($dni) {
                          $q->where('dni', 'like', '%' . $dni . '%');
                      });
            })
            ->when($request->filtro_escuela, function ($query, $escuela) {
                $query->where('beneficiarios_svo.id_escuela', $escuela);
            })
            ->when($request->filtro_estado !== null && $request->filtro_estado !== '', function ($query, $estado) {
                $query->where('beneficiarios_svo.activo', $estado === '1');
            });

        $usuario = Auth::user();
        if ($usuario && $usuario->rol === 'usuario_general') {
            $query->where('beneficiarios_svo.id_escuela', $usuario->id_escuela);
        }

        return $query->orderBy('apellido', 'asc')->get();
    }
}