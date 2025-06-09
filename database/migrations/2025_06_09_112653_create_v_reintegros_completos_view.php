<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE VIEW `v_reintegros_completos` AS select `r`.`id_reintegro` AS `id_reintegro`,`r`.`fecha_solicitud` AS `fecha_solicitud`,`ctg`.`nombre_tipo_gasto` AS `tipo_gasto`,`r`.`descripcion_gasto` AS `descripcion_gasto`,`r`.`monto_solicitado` AS `monto_solicitado`,`cer`.`nombre_estado` AS `estado_reintegro`,`r`.`monto_autorizado` AS `monto_autorizado`,`r`.`fecha_pago` AS `fecha_pago`,`r`.`numero_transferencia` AS `numero_transferencia`,`a`.`numero_expediente` AS `numero_expediente`,`a`.`fecha_accidente` AS `fecha_accidente`,`al`.`nombre` AS `alumno_nombre`,`al`.`apellido` AS `alumno_apellido`,`e`.`nombre` AS `escuela_nombre`,`us`.`nombre` AS `solicitante_nombre`,`us`.`apellido` AS `solicitante_apellido`,`ua`.`nombre` AS `auditor_nombre`,`ua`.`apellido` AS `auditor_apellido` from (((((((`fondo_solidario_jaec`.`reintegros` `r` join `fondo_solidario_jaec`.`accidentes` `a` on(`r`.`id_accidente` = `a`.`id_accidente`)) join `fondo_solidario_jaec`.`alumnos` `al` on(`a`.`id_alumno` = `al`.`id_alumno`)) join `fondo_solidario_jaec`.`escuelas` `e` on(`a`.`id_escuela` = `e`.`id_escuela`)) join `fondo_solidario_jaec`.`usuarios` `us` on(`r`.`id_usuario_solicita` = `us`.`id_usuario`)) left join `fondo_solidario_jaec`.`usuarios` `ua` on(`r`.`id_medico_auditor` = `ua`.`id_usuario`)) left join `fondo_solidario_jaec`.`cat_estados_reintegros` `cer` on(`r`.`id_estado_reintegro` = `cer`.`id_estado_reintegro`)) left join `fondo_solidario_jaec`.`cat_tipos_gastos` `ctg` on(`r`.`id_tipo_gasto` = `ctg`.`id_tipo_gasto`))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `v_reintegros_completos`");
    }
};
