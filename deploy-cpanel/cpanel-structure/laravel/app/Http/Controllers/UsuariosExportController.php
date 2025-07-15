<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UsuariosExportController extends Controller
{
    private function getEntidadesFiltradas(Request $request)
    {
        return User::query()
            ->with(['role', 'escuela'])
            ->when($request->filtro_nombre, function ($query, $nombre) {
                $query->where('nombre', 'like', '%' . $nombre . '%')
                      ->orWhere('apellido', 'like', '%' . $nombre . '%');
            })
            ->when($request->filtro_email, function ($query, $email) {
                $query->where('email', 'like', '%' . $email . '%');
            })
            ->when($request->filtro_rol, function ($query, $rol) {
                $query->where('id_rol', $rol);
            })
            ->when($request->filtro_escuela, function ($query, $escuela) {
                $query->where('id_escuela', $escuela);
            })
            ->when($request->filtro_estado !== null && $request->filtro_estado !== '', function ($query, $estado) {
                $query->where('activo', $estado);
            })
            ->orderBy('apellido', 'asc')
            ->get();
    }

    public function exportarCSV(Request $request)
    {
        $usuarios = $this->getEntidadesFiltradas($request);
        $filename = 'usuarios_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($usuarios) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, ['Apellido', 'Nombre', 'Email', 'Rol', 'Escuela', 'Estado'], ',', '"');

            foreach ($usuarios as $usuario) {
                fputcsv($file, [
                    export_clean($usuario->apellido),
                    export_clean($usuario->nombre),
                    export_clean($usuario->email),
                    export_clean($usuario->role->nombre_rol ?? 'N/A'),
                    export_clean($usuario->escuela->nombre ?? 'N/A'),
                    $usuario->activo ? 'Activo' : 'Inactivo',
                ], ',', '"');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportarExcel(Request $request)
    {
        $usuarios = $this->getEntidadesFiltradas($request);
        $filename = 'usuarios_' . date('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $html = $this->generarHTMLParaExcel($usuarios);
        return Response::make($html, 200, $headers);
    }

    private function generarHTMLParaExcel($usuarios)
    {
        $html = '<?xml version="1.0" encoding="UTF-8"?>
        <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
         xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">
         <Styles>
          <Style ss:ID="Header"><Font ss:Bold="1"/></Style>
         </Styles>
         <Worksheet ss:Name="Usuarios">
          <Table>
           <Row>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Apellido</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Nombre</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Email</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Rol</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Escuela</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Estado</Data></Cell>
           </Row>';

        foreach ($usuarios as $usuario) {
            $html .= '<Row>
             <Cell><Data ss:Type="String">' . export_clean($usuario->apellido) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($usuario->nombre) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($usuario->email) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($usuario->role->nombre_rol ?? 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($usuario->escuela->nombre ?? 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="String">' . ($usuario->activo ? 'Activo' : 'Inactivo') . '</Data></Cell>
            </Row>';
        }

        $html .= '  </Table>
         </Worksheet>
        </Workbook>';

        return $html;
    }
}