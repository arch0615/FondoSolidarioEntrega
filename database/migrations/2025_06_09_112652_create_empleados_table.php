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
        Schema::create('empleados', function (Blueprint $table) {
            $table->integer('id_empleado', true);
            $table->integer('id_escuela')->index('idx_escuela');
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('dni', 10)->nullable()->unique('uk_dni');
            $table->string('cuil', 15)->nullable()->unique('uk_cuil');
            $table->string('cargo', 100)->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_egreso')->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('direccion', 300)->nullable();
            $table->boolean('activo')->nullable()->default(true)->index('idx_activo');

            $table->index(['nombre', 'apellido'], 'idx_nombre_apellido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
