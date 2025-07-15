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
        Schema::create('salidas_educativas', function (Blueprint $table) {
            $table->integer('id_salida', true);
            $table->integer('id_escuela')->index('idx_escuela');
            $table->integer('id_usuario_carga')->index('id_usuario_carga');
            $table->date('fecha_salida')->index('idx_fecha_salida');
            $table->time('hora_salida')->nullable();
            $table->time('hora_regreso')->nullable();
            $table->string('destino', 300)->nullable();
            $table->string('proposito', 500)->nullable();
            $table->string('grado_curso', 50)->nullable();
            $table->integer('cantidad_alumnos')->nullable();
            $table->string('docentes_acompanantes', 500)->nullable();
            $table->string('transporte', 200)->nullable();
            $table->dateTime('fecha_carga')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salidas_educativas');
    }
};
