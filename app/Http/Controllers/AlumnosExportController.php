<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AlumnosExportController extends Controller
{
    private function getAlumnosFiltrados(Request $request)
    {
        $query = Alumno::query()->with('escuela');
        $user = Auth::user();

        // Restricción por rol
        if ($user->id_rol == 1 && $user->id_escuela) {
            $query->where('id_escuela', $user->id_escuela);
        }

        // Aplicar filtros de la request
        if ($request->has('filtro_nombre') && $request->filtro_nombre) {
            $query->where('nombre', 'like', '%' . $request->filtro_nombre . '%');
        }
        if ($request->has('filtro_apellido') && $request->filtro_apellido) {
            $query->where('apellido', 'like', '%' . $request->filtro_apellido . '%');
        }
        if ($request->has('filtro_dni') && $request->filtro_dni) {
            $query->where('dni', 'like', '%' . $request->filtro_dni . '%');
        }
        if ($request->has('filtro_grado') && $request->filtro_grado) {
            $query->where('sala_grado_curso', 'like', '%' . $request->filtro_grado . '%');
        }
        if ($request->has('filtro_escuela') && $request->filtro_escuela && $user->id_rol != 1) {
            $query->where('id_escuela', $request->filtro_escuela);
        }
        if ($request->has('filtro_estado') && $request->filtro_estado !== '') {
            $activo = $request->filtro_estado === 'activo';
            $query->where('activo', $activo);
        }

        return $query->orderBy('apellido')->get();
    }

    public function exportarCSV(Request $request)
    {
        $alumnos = $this->getAlumnosFiltrados($request);
        $filename = 'alumnos_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($alumnos) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM para UTF-8
            
            fputcsv($file, ['Apellido', 'Nombre', 'DNI', 'Familiar 1', 'Parentesco 1', 'Teléfono 1', 'Familiar 2', 'Parentesco 2', 'Teléfono 2', 'Familiar 3', 'Parentesco 3', 'Teléfono 3', 'Fecha Nacimiento', 'Obra Social', 'Deportes', 'Escuela', 'Estado']);

            foreach ($alumnos as $alumno) {
                fputcsv($file, [
                    export_clean($alumno->apellido),
                    export_clean($alumno->nombre),
                    export_clean($alumno->dni),
                    export_clean($alumno->familiar1),
                    export_clean($alumno->parentesco1),
                    export_clean($alumno->telefono_contacto1),
                    export_clean($alumno->familiar2),
                    export_clean($alumno->parentesco2),
                    export_clean($alumno->telefono_contacto2),
                    export_clean($alumno->familiar3),
                    export_clean($alumno->parentesco3),
                    export_clean($alumno->telefono_contacto3),
                    export_clean($alumno->fecha_nacimiento ? $alumno->fecha_nacimiento->format('d/m/Y') : ''),
                    export_clean($alumno->obra_social),
                    export_clean($alumno->deportes),
                    export_clean($alumno->escuela->nombre ?? 'N/A'),
                    export_clean($alumno->activo ? 'Activo' : 'Inactivo'),
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportarExcel(Request $request)
    {
        $alumnos = $this->getAlumnosFiltrados($request);
        $filename = 'alumnos_' . date('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $html = $this->generarHTMLParaExcel($alumnos);
        return Response::make($html, 200, $headers);
    }

    private function generarHTMLParaExcel($alumnos)
    {
        $html = '<?xml version="1.0" encoding="UTF-8"?>
        <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:o="urn:schemas-microsoft-com:office:office"
         xmlns:x="urn:schemas-microsoft-com:office:excel"
         xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:html="http://www.w3.org/TR/REC-html40">
         <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
          <Title>Reporte de Alumnos</Title>
          <Author>Sistema Fondo Solidario</Author>
          <Created>' . date('Y-m-d\TH:i:s\Z') . '</Created>
         </DocumentProperties>
         <Styles>
          <Style ss:ID="Header">
           <Font ss:Bold="1"/>
           <Interior ss:Color="#CCCCCC" ss:Pattern="Solid"/>
          </Style>
         </Styles>
         <Worksheet ss:Name="Alumnos">
          <Table>
           <Row>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Apellido</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Nombre</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">DNI</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Familiar 1</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Parentesco 1</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Teléfono 1</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Familiar 2</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Parentesco 2</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Teléfono 2</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Familiar 3</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Parentesco 3</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Teléfono 3</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Nacimiento</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Obra Social</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Deportes</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Escuela</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Estado</Data></Cell>
           </Row>';

        foreach ($alumnos as $alumno) {
            $html .= '<Row>
             <Cell><Data ss:Type="String">' . export_clean($alumno->apellido) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->nombre) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->dni) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->familiar1) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->parentesco1) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->telefono_contacto1) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->familiar2) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->parentesco2) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->telefono_contacto2) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->familiar3) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->parentesco3) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->telefono_contacto3) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->fecha_nacimiento ? $alumno->fecha_nacimiento->format('d/m/Y') : '') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->obra_social) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->deportes) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->escuela->nombre ?? 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($alumno->activo ? 'Activo' : 'Inactivo') . '</Data></Cell>
            </Row>';
        }

        $html .= '  </Table>
         </Worksheet>
        </Workbook>';

        return $html;
    }

    public function exportarPDF(Request $request)
    {
        $alumnos = $this->getAlumnosFiltrados($request);
        $html = view('exports.alumnos_pdf', compact('alumnos'))->render();
        
        $headers = [
            'Content-Type' => 'text/html; charset=UTF-8',
        ];

        return Response::make($html, 200, $headers);
    }
}
