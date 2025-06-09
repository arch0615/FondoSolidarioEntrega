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
        Schema::create('solicitudes_info_auditor', function (Blueprint $table) {
            $table->integer('id_solicitud', true);
            $table->integer('id_reintegro')->index('idx_reintegro');
            $table->integer('id_auditor')->index('idx_auditor');
            $table->dateTime('fecha_solicitud')->nullable()->useCurrent()->index('idx_fecha_solicitud');
            $table->text('descripcion_solicitud')->nullable();
            $table->string('documentos_requeridos', 500)->nullable();
            $table->integer('id_estado_solicitud')->nullable()->index('idx_estado_solicitud');
            $table->integer('id_usuario_responde')->nullable()->index('id_usuario_responde');
            $table->dateTime('fecha_respuesta')->nullable();
            $table->text('observaciones_respuesta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_info_auditor');
    }
};
