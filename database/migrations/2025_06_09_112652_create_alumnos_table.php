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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->integer('id_alumno', true);
            $table->integer('id_escuela')->index('idx_escuela');
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('dni', 10)->nullable()->unique('uk_dni');
            $table->string('cuil', 15)->nullable()->unique('uk_cuil');
            $table->string('sala_grado_curso', 50)->nullable();
            $table->string('familiar1', 200)->nullable();
            $table->string('parentesco1', 100)->nullable();
            $table->string('telefono_contacto1', 50)->nullable();
            $table->string('familiar2', 200)->nullable();
            $table->string('parentesco2', 100)->nullable();
            $table->string('telefono_contacto2', 50)->nullable();
            $table->string('familiar3', 200)->nullable();
            $table->string('parentesco3', 100)->nullable();
            $table->string('telefono_contacto3', 50)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->boolean('activo')->nullable()->default(true)->index('idx_activo');
            $table->text('obra_social')->nullable();
            $table->text('deportes')->nullable();

            $table->index(['nombre', 'apellido'], 'idx_nombre_apellido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
