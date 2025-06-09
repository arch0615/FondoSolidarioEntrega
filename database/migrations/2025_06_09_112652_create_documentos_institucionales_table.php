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
        Schema::create('documentos_institucionales', function (Blueprint $table) {
            $table->integer('id_documento', true);
            $table->integer('id_escuela')->index('idx_escuela');
            $table->string('nombre_documento', 200);
            $table->string('descripcion', 500)->nullable();
            $table->date('fecha_documento')->nullable();
            $table->date('fecha_vencimiento')->nullable()->index('idx_fecha_vencimiento');
            $table->integer('id_usuario_carga')->index('id_usuario_carga');
            $table->dateTime('fecha_carga')->nullable()->useCurrent();
            $table->integer('id_tipo_documento')->nullable()->index('fk_documentos_tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_institucionales');
    }
};
