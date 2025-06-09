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
        Schema::create('archivos_adjuntos', function (Blueprint $table) {
            $table->integer('id_archivo', true);
            $table->string('tipo_entidad', 50);
            $table->integer('id_entidad');
            $table->string('nombre_archivo');
            $table->string('tipo_archivo', 10)->nullable();
            $table->integer('tama??o')->nullable();
            $table->string('ruta_archivo', 500);
            $table->string('descripcion', 500)->nullable();
            $table->integer('id_usuario_carga')->index('idx_usuario_carga');
            $table->dateTime('fecha_carga')->nullable()->useCurrent()->index('idx_fecha_carga');

            $table->index(['tipo_entidad', 'id_entidad'], 'idx_entidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos_adjuntos');
    }
};
