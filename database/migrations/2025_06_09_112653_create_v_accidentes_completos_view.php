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
        DB::statement("CREATE VIEW `v_accidentes_completos` AS select `a`.`id_accidente` AS `id_accidente`,`a`.`numero_expediente` AS `numero_expediente`,`a`.`fecha_accidente` AS `fecha_accidente`,`a`.`hora_accidente` AS `hora_accidente`,`a`.`lugar_accidente` AS `lugar_accidente`,`a`.`descripcion_accidente` AS `descripcion_accidente`,`a`.`tipo_lesion` AS `tipo_lesion`,`a`.`protocolo_activado` AS `protocolo_activado`,`a`.`llamada_emergencia` AS `llamada_emergencia`,`cea`.`nombre_estado` AS `estado_accidente`,`al`.`nombre` AS `alumno_nombre`,`al`.`apellido` AS `alumno_apellido`,`al`.`dni` AS `alumno_dni`,`e`.`nombre` AS `escuela_nombre`,`u`.`nombre` AS `usuario_nombre`,`u`.`apellido` AS `usuario_apellido` from ((((`fondo_solidario_jaec`.`accidentes` `a` join `fondo_solidario_jaec`.`alumnos` `al` on(`a`.`id_alumno` = `al`.`id_alumno`)) join `fondo_solidario_jaec`.`escuelas` `e` on(`a`.`id_escuela` = `e`.`id_escuela`)) join `fondo_solidario_jaec`.`usuarios` `u` on(`a`.`id_usuario_carga` = `u`.`id_usuario`)) left join `fondo_solidario_jaec`.`cat_estados_accidentes` `cea` on(`a`.`id_estado_accidente` = `cea`.`id_estado_accidente`))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS `v_accidentes_completos`");
    }
};
