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
        Schema::create('alumnos_salidas', function (Blueprint $table) {
            $table->integer('id_alumno_salida', true);
            $table->integer('id_salida')->index('idx_salida');
            $table->integer('id_alumno')->index('idx_alumno');
            $table->boolean('autorizado')->nullable()->default(true);

            $table->unique(['id_salida', 'id_alumno'], 'uk_salida_alumno');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos_salidas');
    }
};
