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
        Schema::create('escuelas', function (Blueprint $table) {
            $table->integer('id_escuela', true);
            $table->string('codigo_escuela', 20)->nullable()->unique('uk_codigo_escuela');
            $table->string('nombre', 200)->index('idx_nombre');
            $table->string('direccion', 300)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->decimal('aporte_por_alumno', 10)->nullable()->default(0);
            $table->date('fecha_alta')->nullable();
            $table->boolean('activo')->nullable()->default(true)->index('idx_activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escuelas');
    }
};
