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
        Schema::create('pasantias', function (Blueprint $table) {
            $table->integer('id_pasantia', true);
            $table->integer('id_escuela')->index('idx_escuela');
            $table->integer('id_alumno')->index('idx_alumno');
            $table->string('empresa', 200);
            $table->string('direccion_empresa', 300)->nullable();
            $table->string('tutor_empresa', 200)->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->string('horario', 100)->nullable();
            $table->text('descripcion_tareas')->nullable();
            $table->integer('id_usuario_carga')->index('id_usuario_carga');
            $table->dateTime('fecha_carga')->nullable()->useCurrent();

            $table->index(['fecha_inicio', 'fecha_fin'], 'idx_fechas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasantias');
    }
};
