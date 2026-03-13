<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasantia;
use Illuminate\Support\Facades\Response;
use App\Services\AuditoriaService;
use Illuminate\Support\Facades\Auth;

class PasantiaExportController extends Controller
{
    public function exportCsv(Request $request)
    {
        $pasantias = $this->getPasantiasQuery($request)->get();
        
        $filename = 'pasantias_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($pasantias) {
            $file = fopen('php://output', 'w');
            
            // Escribir BOM para UTF-8
            fwrite($file, "\xEF\xBB\xBF");
            
            // Headers del CSV
            fputcsv($file, [
                'Alumno',
                'DNI',
                'Empresa',
                'Tutor Empresa',
                'Escuela',
                'Fecha Inicio',
                'Fecha Fin',
                'Horario',
                'Descripción Tareas'
            ]);

            // Datos
            foreach ($pasantias as $pasantia) {
                fputcsv($file, [
                    export_clean($pasantia->alumno ? $pasantia->alumno->nombre . ' ' . $pasantia->alumno->apellido : 'Sin alumno'),
                    export_clean($pasantia->alumno ? $pasantia->alumno->numero_documento : ''),
                    export_clean($pasantia->empresa),
                    export_clean($pasantia->tutor_empresa),
                    export_clean($pasantia->escuela ? $pasantia->escuela->nombre : 'Sin escuela'),
                    $pasantia->fecha_inicio ? $pasantia->fecha_inicio->format('d/m/Y') : '',
                    $pasantia->fecha_fin ? $pasantia->fecha_fin->format('d/m/Y') : '',
                    export_clean($pasantia->horario),
                    export_clean($pasantia->descripcion_tareas)
                ]);
            }

            fclose($file);
        };

        // Registrar exportación en auditoría
        AuditoriaService::registrarConsulta('pasantias_export_csv', $request->all());

        return response()->stream($callback, 200, $headers);
    }

    public function exportExcel(Request $request)
    {
        $pasantias = $this->getPasantiasQuery($request)->get();
        $filename = 'pasantias_' . date('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $html = $this->generarHTMLParaExcel($pasantias);
        return Response::make($html, 200, $headers);
    }

    private function generarHTMLParaExcel($pasantias)
    {
        $html = '<?xml version="1.0" encoding="UTF-8"?>
        <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:o="urn:schemas-microsoft-com:office:office"
         xmlns:x="urn:schemas-microsoft-com:office:excel"
         xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:html="http://www.w3.org/TR/REC-html40">
         <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
          <Title>Reporte de Pasantías</Title>
          <Author>Sistema Fondo Solidario</Author>
          <Created>' . date('Y-m-d\TH:i:s\Z') . '</Created>
         </DocumentProperties>
         <Styles>
          <Style ss:ID="Header">
           <Font ss:Bold="1"/>
           <Interior ss:Color="#CCCCCC" ss:Pattern="Solid"/>
          </Style>
         </Styles>
         <Worksheet ss:Name="Pasantias">
          <Table>
           <Row>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Alumno</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">DNI</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Empresa</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Tutor Empresa</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Escuela</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Inicio</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Fin</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Horario</Data></Cell>
           </Row>';

        foreach ($pasantias as $pasantia) {
            $html .= '<Row>
             <Cell><Data ss:Type="String">' . export_clean($pasantia->alumno ? $pasantia->alumno->nombre . ' ' . $pasantia->alumno->apellido : 'Sin alumno') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($pasantia->alumno ? $pasantia->alumno->dni : '') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($pasantia->empresa) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($pasantia->tutor_empresa) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($pasantia->escuela ? $pasantia->escuela->nombre : 'Sin escuela') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . ($pasantia->fecha_inicio ? $pasantia->fecha_inicio->format('d/m/Y') : '') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . ($pasantia->fecha_fin ? $pasantia->fecha_fin->format('d/m/Y') : '') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($pasantia->horario) . '</Data></Cell>
            </Row>';
        }

        $html .= '  </Table>
         </Worksheet>
        </Workbook>';

        return $html;
    }

    public function exportPdf(Request $request)
    {
        $pasantias = $this->getPasantiasQuery($request)->get();
        
        // Registrar exportación en auditoría
        AuditoriaService::registrarConsulta('pasantias_export_pdf', $request->all());

        return view('exports.pasantias_pdf', compact('pasantias'));
    }

    private function getPasantiasQuery(Request $request)
    {
        $query = Pasantia::query()->with(['escuela', 'alumno', 'usuarioCarga']);
        
        // Aplicar filtros
        if ($request->filled('filtro_empresa')) {
            $query->where('empresa', 'like', '%' . $request->filtro_empresa . '%');
        }
        
        if ($request->filled('filtro_alumno')) {
            $query->whereHas('alumno', function ($subQuery) use ($request) {
                $subQuery->where('nombre', 'like', '%' . $request->filtro_alumno . '%')
                        ->orWhere('apellido', 'like', '%' . $request->filtro_alumno . '%');
            });
        }
        
        if ($request->filled('filtro_fecha_inicio')) {
            $query->whereDate('fecha_inicio', '>=', $request->filtro_fecha_inicio);
        }

        // Aplicar filtro por escuela del usuario si es usuario general (rol = 1)
        $usuario = Auth::user();
        if ($usuario && $usuario->id_rol == 1 && $usuario->id_escuela) {
            $query->where('id_escuela', $usuario->id_escuela);
        } else {
            // Si es admin u otro rol, aplicar el filtro de la vista solo si se seleccionó
            if ($request->filled('filtro_escuela')) {
                $query->where('id_escuela', $request->filtro_escuela);
            }
        }

        return $query->orderBy('fecha_inicio', 'desc');
    }
}