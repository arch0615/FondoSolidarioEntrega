<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertar datos en cat_estados_accidentes (solo si no existen)
        $estados_accidentes = [
            ['id_estado_accidente' => 1, 'nombre_estado' => 'Abierto', 'descripcion' => 'El accidente ha sido registrado y está activo.'],
            ['id_estado_accidente' => 2, 'nombre_estado' => 'En Investigación', 'descripcion' => 'El accidente está siendo investigado.'],
            ['id_estado_accidente' => 3, 'nombre_estado' => 'Cerrado', 'descripcion' => 'El accidente ha sido resuelto y cerrado.'],
            ['id_estado_accidente' => 4, 'nombre_estado' => 'Pendiente Documentación', 'descripcion' => 'Se requiere más documentación para el accidente.'],
        ];
        foreach ($estados_accidentes as $estado) {
            DB::table('cat_estados_accidentes')->updateOrInsert(
                ['id_estado_accidente' => $estado['id_estado_accidente']],
                $estado
            );
        }

        // Insertar datos en cat_estados_reintegros (solo si no existen)
        $estados_reintegros = [
            ['id_estado_reintegro' => 1, 'nombre_estado' => 'En proceso', 'descripcion' => 'La solicitud de reintegro ha sido recibida y está siendo procesada.'],
            ['id_estado_reintegro' => 2, 'nombre_estado' => 'Requiere Información', 'descripcion' => 'Se necesita información adicional para procesar el reintegro.'],
            ['id_estado_reintegro' => 3, 'nombre_estado' => 'Autorizado', 'descripcion' => 'El reintegro ha sido aprobado por el médico auditor.'],
            ['id_estado_reintegro' => 4, 'nombre_estado' => 'Rechazado', 'descripcion' => 'El reintegro ha sido rechazado.'],
            ['id_estado_reintegro' => 5, 'nombre_estado' => 'Pagado', 'descripcion' => 'El reintegro ha sido pagado.'],
            ['id_estado_reintegro' => 6, 'nombre_estado' => 'Enviado a Aseguradora', 'descripcion' => 'El reintegro ha sido enviado a la compañía aseguradora.'],
        ];
        foreach ($estados_reintegros as $estado) {
            DB::table('cat_estados_reintegros')->updateOrInsert(
                ['id_estado_reintegro' => $estado['id_estado_reintegro']],
                $estado
            );
        }

        // Insertar datos en cat_estados_solicitudes (solo si no existen)
        $estados_solicitudes = [
            ['id_estado_solicitud' => 1, 'nombre_estado' => 'Pendiente', 'descripcion' => 'La solicitud de información está esperando respuesta.'],
            ['id_estado_solicitud' => 2, 'nombre_estado' => 'Respondida', 'descripcion' => 'La solicitud de información ha sido respondida.'],
            ['id_estado_solicitud' => 3, 'nombre_estado' => 'Cerrada', 'descripcion' => 'La solicitud de información ha sido cerrada.'],
        ];
        foreach ($estados_solicitudes as $estado) {
            DB::table('cat_estados_solicitudes')->updateOrInsert(
                ['id_estado_solicitud' => $estado['id_estado_solicitud']],
                $estado
            );
        }

        // Insertar datos en cat_parentescos (solo si no existen)
        $parentescos = [
            ['id_parentesco' => 1, 'nombre_parentesco' => 'Cónyuge'],
            ['id_parentesco' => 2, 'nombre_parentesco' => 'Hijo/a'],
            ['id_parentesco' => 3, 'nombre_parentesco' => 'Padre'],
            ['id_parentesco' => 4, 'nombre_parentesco' => 'Madre'],
            ['id_parentesco' => 5, 'nombre_parentesco' => 'Hermano/a'],
            ['id_parentesco' => 6, 'nombre_parentesco' => 'Otro'],
        ];
        foreach ($parentescos as $parentesco) {
            DB::table('cat_parentescos')->updateOrInsert(
                ['id_parentesco' => $parentesco['id_parentesco']],
                $parentesco
            );
        }

        // Insertar datos en cat_tipos_documentos (solo si no existen)
        $tipos_documentos = [
            ['id_tipo_documento' => 1, 'nombre_tipo_documento' => 'Reglamento Interno'],
            ['id_tipo_documento' => 2, 'nombre_tipo_documento' => 'Plan de Evacuación'],
            ['id_tipo_documento' => 3, 'nombre_tipo_documento' => 'Protocolo COVID-19'],
            ['id_tipo_documento' => 4, 'nombre_tipo_documento' => 'Certificado de Habilitación'],
            ['id_tipo_documento' => 5, 'nombre_tipo_documento' => 'Otro'],
        ];
        foreach ($tipos_documentos as $tipo) {
            DB::table('cat_tipos_documentos')->updateOrInsert(
                ['id_tipo_documento' => $tipo['id_tipo_documento']],
                $tipo
            );
        }

        // Insertar datos en cat_tipos_gastos (solo si no existen)
        $tipos_gastos = [
            ['id_tipo_gasto' => 1, 'nombre_tipo_gasto' => 'Consulta Médica', 'descripcion' => 'Gastos por consulta con un profesional médico.'],
            ['id_tipo_gasto' => 2, 'nombre_tipo_gasto' => 'Medicamentos', 'descripcion' => 'Gastos por compra de medicamentos recetados.'],
            ['id_tipo_gasto' => 3, 'nombre_tipo_gasto' => 'Estudios Médicos', 'descripcion' => 'Gastos por estudios y análisis clínicos.'],
            ['id_tipo_gasto' => 4, 'nombre_tipo_gasto' => 'Material Ortopédico', 'descripcion' => 'Gastos por material ortopédico o de curación.'],
            ['id_tipo_gasto' => 5, 'nombre_tipo_gasto' => 'Traslados', 'descripcion' => 'Gastos por traslados en ambulancia o similar.'],
            ['id_tipo_gasto' => 6, 'nombre_tipo_gasto' => 'Otros', 'descripcion' => 'Otros gastos médicos relacionados.'],
        ];
        foreach ($tipos_gastos as $tipo) {
            DB::table('cat_tipos_gastos')->updateOrInsert(
                ['id_tipo_gasto' => $tipo['id_tipo_gasto']],
                $tipo
            );
        }

        // Insertar datos en cat_tipos_prestadores (solo si no existen)
        $tipos_prestadores = [
            ['id_tipo_prestador' => 1, 'nombre_tipo_prestador' => 'Clínica', 'descripcion' => 'Clínica médica general o especializada.'],
            ['id_tipo_prestador' => 2, 'nombre_tipo_prestador' => 'Hospital', 'descripcion' => 'Hospital público o privado.'],
            ['id_tipo_prestador' => 3, 'nombre_tipo_prestador' => 'Consultorio Médico', 'descripcion' => 'Consultorio particular de un médico.'],
            ['id_tipo_prestador' => 4, 'nombre_tipo_prestador' => 'Laboratorio de Análisis', 'descripcion' => 'Laboratorio para estudios clínicos.'],
            ['id_tipo_prestador' => 5, 'nombre_tipo_prestador' => 'Centro de Diagnóstico', 'descripcion' => 'Centro especializado en diagnósticos por imágenes.'],
            ['id_tipo_prestador' => 6, 'nombre_tipo_prestador' => 'Farmacia', 'descripcion' => 'Establecimiento de venta de medicamentos.'],
            ['id_tipo_prestador' => 7, 'nombre_tipo_prestador' => 'Servicio de Emergencias', 'descripcion' => 'Servicio de atención médica de urgencia.'],
        ];
        foreach ($tipos_prestadores as $tipo) {
            DB::table('cat_tipos_prestadores')->updateOrInsert(
                ['id_tipo_prestador' => $tipo['id_tipo_prestador']],
                $tipo
            );
        }

        // Insertar datos en roles (solo si no existen)
        $roles = [
            ['id_rol' => 1, 'nombre_rol' => 'Usuario General', 'descripcion' => 'Personal de escuela con acceso básico al sistema', 'activo' => 1],
            ['id_rol' => 2, 'nombre_rol' => 'Administrador', 'descripcion' => 'Personal JAEC con acceso completo al sistema', 'activo' => 1],
            ['id_rol' => 3, 'nombre_rol' => 'Médico Auditor', 'descripcion' => 'Profesional médico que evalúa los reintegros', 'activo' => 1],
        ];
        foreach ($roles as $rol) {
            DB::table('roles')->updateOrInsert(
                ['id_rol' => $rol['id_rol']],
                $rol
            );
        }
    }
}
