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
        Schema::create('beneficiarios_svo', function (Blueprint $table) {
            $table->integer('id_beneficiario', true);
            $table->integer('id_empleado')->index('idx_empleado');
            $table->integer('id_escuela')->nullable()->index('fk_beneficiario_escuela');
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('dni', 10)->nullable();
            $table->decimal('porcentaje', 5)->nullable();
            $table->date('fecha_alta')->nullable();
            $table->boolean('activo')->nullable()->default(true)->index('idx_activo');
            $table->integer('id_parentesco')->nullable()->index('fk_beneficiarios_parentesco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiarios_svo');
    }
};
