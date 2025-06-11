<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accidentes', function (Blueprint $table) {
            $table->integer('id_accidente', true);
            $table->string('numero_expediente', 20)->nullable()->unique('numero_expediente');
            $table->integer('id_escuela')->index('idx_escuela');
            $table->integer('id_alumno')->index('idx_alumno');
            $table->integer('id_usuario_carga')->index('id_usuario_carga');
            $table->date('fecha_accidente')->index('idx_fecha');
            $table->time('hora_accidente')->nullable();
            $table->string('lugar_accidente', 200)->nullable();
            $table->text('descripcion_accidente')->nullable();
            $table->string('tipo_lesion', 200)->nullable();
            $table->boolean('protocolo_activado')->nullable()->default(false);
            $table->boolean('llamada_emergencia')->nullable()->default(false);
            $table->time('hora_llamada')->nullable();
            $table->string('servicio_emergencia', 100)->nullable();
            $table->integer('id_estado_accidente')->nullable()->index('idx_estado_accidente');
            $table->dateTime('fecha_carga')->nullable();

            $table->index(['fecha_accidente', 'id_escuela'], 'idx_accidentes_fecha_escuela');
            $table->unique(['numero_expediente'], 'uk_numero_expediente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accidentes');
    }
};
