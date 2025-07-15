<?xml version="1.0" encoding="UTF-8"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Title>Reporte de Accesos de Auditoría</Title>
  <Author>Sistema Fondo Solidario</Author>
  <Created><?php echo e(date('Y-m-d\TH:i:s\Z')); ?></Created>
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
<?php $__currentLoopData = $registros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <Row>
    <Cell><Data ss:Type="String"><?php echo e($registro->fecha_hora->format('d/m/Y H:i:s')); ?></Data></Cell>
    <Cell><Data ss:Type="String"><?php echo e($registro->usuario->nombre_completo ?? 'N/A'); ?></Data></Cell>
    <Cell><Data ss:Type="String"><?php echo e($registro->accion); ?></Data></Cell>
    <Cell><Data ss:Type="String"><?php echo e($registro->ip_usuario); ?></Data></Cell>
   </Row>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </Table>
 </Worksheet>
</Workbook><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\exports\auditoria_accesos_excel.blade.php ENDPATH**/ ?>