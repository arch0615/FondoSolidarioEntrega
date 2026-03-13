<?php

namespace App\Http\Controllers;

use App\Models\SalidaEducativa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class SalidaEducativaExportController extends Controller
{
    public function exportarCSV(Request $request)
    {
        $salidas = $this->getSalidasFiltradas($request);
        
        $filename = 'salidas_educativas_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($salidas) {
            $file = fopen('php://output', 'w');
            
            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, [
                'ID',
                'Fecha y Horario',
                'Destino',
                'Propósito',
                'Escuela',
                'Cantidad Alumnos',
                'Docentes Acompañantes',
                'Transporte',
                'Fecha Carga'
            ], ',', '"');

            foreach ($salidas as $salida) {
                $fechaHorario = $salida->fecha_salida->format('d/m/Y') . "\n" .
                               ($salida->hora_salida ? $salida->hora_salida->format('H:i') : 'N/A') . ' - ' .
                               ($salida->hora_regreso ? $salida->hora_regreso->format('H:i') : 'N/A');

                fputcsv($file, [
                    $salida->id_salida,
                    $fechaHorario,
                    export_clean($salida->destino),
                    export_clean($salida->proposito),
                    export_clean($salida->escuela->nombre ?? 'N/A'),
                    $salida->cantidad_alumnos,
                    export_clean($salida->docentes_acompanantes),
                    export_clean($salida->transporte),
                    $salida->fecha_carga->format('d/m/Y H:i')
                ], ',', '"');
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportarExcel(Request $request)
    {
        $salidas = $this->getSalidasFiltradas($request);
        
        $filename = 'salidas_educativas_' . date('Y-m-d_H-i-s') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $html = $this->generarHTMLParaExcel($salidas);

        return Response::make($html, 200, $headers);
    }

    public function exportarPDF(Request $request)
    {
        $salidas = $this->getSalidasFiltradas($request);
        
        $html = $this->generarHTMLParaPDF($salidas);
        
        $headers = [
            'Content-Type' => 'text/html; charset=UTF-8',
        ];

        return Response::make($html, 200, $headers);
    }

    private function getSalidasFiltradas(Request $request)
    {
        $query = SalidaEducativa::query()->with('escuela');

        if ($request->has('filtro_destino') && $request->filtro_destino) {
            $query->where('destino', 'like', '%' . $request->filtro_destino . '%');
        }

        if ($request->has('filtro_escuela') && $request->filtro_escuela) {
            $query->where('id_escuela', $request->filtro_escuela);
        }

        if ($request->has('filtro_fecha') && $request->filtro_fecha) {
            $query->whereDate('fecha_salida', $request->filtro_fecha);
        }

        $usuario = Auth::user();
        if ($usuario && $usuario->id_rol == 2 && $usuario->id_escuela) { // Rol Escuela
            $query->where('id_escuela', $usuario->id_escuela);
        }

        return $query->orderBy('fecha_salida', 'desc')->get();
    }

    private function generarHTMLParaExcel($salidas)
    {
        $html = '<?xml version="1.0" encoding="UTF-8"?>
        <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">
         <Styles>
          <Style ss:ID="Header"><Font ss:Bold="1"/></Style>
         </Styles>
         <Worksheet ss:Name="Salidas Educativas">
          <Table>
           <Row>
            <Cell ss:StyleID="Header"><Data ss:Type="String">ID</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha y Horario</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Destino</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Propósito</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Escuela</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Alumnos</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Docentes Acompañantes</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Transporte</Data></Cell>
            <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha Carga</Data></Cell>
           </Row>';

        foreach ($salidas as $salida) {
            $fechaHorario = $salida->fecha_salida->format('d/m/Y') . "\n" .
                           ($salida->hora_salida ? $salida->hora_salida->format('H:i') : 'N/A') . ' - ' .
                           ($salida->hora_regreso ? $salida->hora_regreso->format('H:i') : 'N/A');

            $html .= '<Row>
             <Cell><Data ss:Type="Number">' . $salida->id_salida . '</Data></Cell>
             <Cell><Data ss:Type="String">' . $fechaHorario . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($salida->destino) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($salida->proposito) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($salida->escuela->nombre ?? 'N/A') . '</Data></Cell>
             <Cell><Data ss:Type="Number">' . $salida->cantidad_alumnos . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($salida->docentes_acompanantes) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . export_clean($salida->transporte) . '</Data></Cell>
             <Cell><Data ss:Type="String">' . $salida->fecha_carga->format('d/m/Y H:i') . '</Data></Cell>
            </Row>';
        }

        $html .= '  </Table>
         </Worksheet>
        </Workbook>';

        return $html;
    }

    private function generarHTMLParaPDF($salidas)
    {
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Salidas Educativas</title>
            <style>
                body { font-family: Arial, sans-serif; font-size: 12px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .header { text-align: center; margin-bottom: 20px; }
                .no-print { margin-bottom: 20px; text-align: center; }
                .fecha-horario { font-size: 11px; }
                .horario { color: #0066cc; font-size: 10px; font-weight: normal; }
            </style>
        </head>
        <body>
            <div class="header"><h1>Reporte de Salidas Educativas</h1></div>
            <div class="no-print">
                <button onclick="window.print()">Imprimir / Guardar como PDF</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha y Horario</th>
                        <th>Destino</th>
                        <th>Propósito</th>
                        <th>Escuela</th>
                        <th>Alumnos</th>
                        <th>Docentes Acompañantes</th>
                        <th>Transporte</th>
                        <th>Fecha Carga</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($salidas as $salida) {
            $fechaHorario = '<div class="fecha-horario">' . $salida->fecha_salida->format('d/m/Y') . '</div>';
            $fechaHorario .= '<div class="horario">' .
                           ($salida->hora_salida ? $salida->hora_salida->format('H:i') : 'N/A') . ' - ' .
                           ($salida->hora_regreso ? $salida->hora_regreso->format('H:i') : 'N/A') .
                           '</div>';

            $html .= '<tr>
                <td>' . $salida->id_salida . '</td>
                <td>' . $fechaHorario . '</td>
                <td>' . export_clean($salida->destino) . '</td>
                <td>' . export_clean($salida->proposito) . '</td>
                <td>' . export_clean($salida->escuela->nombre ?? 'N/A') . '</td>
                <td>' . $salida->cantidad_alumnos . '</td>
                <td>' . export_clean($salida->docentes_acompanantes) . '</td>
                <td>' . export_clean($salida->transporte) . '</td>
                <td>' . $salida->fecha_carga->format('d/m/Y H:i') . '</td>
            </tr>';
        }

        $html .= '</tbody></table></body></html>';

        return $html;
    }
}
