<?xml version="1.0" encoding="UTF-8"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Title>Reporte de Accesos de Auditoría</Title>
  <Author>Sistema Fondo Solidario</Author>
  <Created>{{ date('Y-m-d\TH:i:s\Z') }}</Created>
 </DocumentProperties>
 <Styles>
  <Style ss:ID="Header">
   <Font ss:Bold="1"/>
   <Interior ss:Color="#CCCCCC" ss:Pattern="Solid"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Accesos">
  <Table>
   <Row>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Fecha y Hora</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Usuario</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">Acción</Data></Cell>
    <Cell ss:StyleID="Header"><Data ss:Type="String">IP</Data></Cell>
   </Row>
@foreach ($registros as $registro)
   <Row>
    <Cell><Data ss:Type="String">{{ $registro->fecha_hora->format('d/m/Y H:i:s') }}</Data></Cell>
    <Cell><Data ss:Type="String">{{ $registro->usuario->nombre_completo ?? 'N/A' }}</Data></Cell>
    <Cell><Data ss:Type="String">{{ $registro->accion }}</Data></Cell>
    <Cell><Data ss:Type="String">{{ $registro->ip_usuario }}</Data></Cell>
   </Row>
@endforeach
  </Table>
 </Worksheet>
</Workbook>