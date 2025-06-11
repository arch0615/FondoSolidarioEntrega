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
        Schema::create('reintegros', function (Blueprint $table) {
            $table->integer('id_reintegro', true);
            $table->integer('id_accidente')->index('idx_accidente');
            $table->integer('id_usuario_solicita')->index('id_usuario_solicita');
            $table->dateTime('fecha_solicitud')->nullable()->index('idx_fecha_solicitud');
            $table->integer('id_tipo_gasto')->nullable()->index('idx_tipo_gasto');
            $table->string('descripcion_gasto', 500)->nullable();
            $table->decimal('monto_solicitado', 10);
            $table->integer('id_estado_reintegro')->nullable()->index('idx_estado_reintegro');
            $table->boolean('requiere_mas_info')->nullable()->default(false);
            $table->integer('id_medico_auditor')->nullable()->index('idx_medico_auditor');
            $table->dateTime('fecha_auditoria')->nullable();
            $table->text('observaciones_auditor')->nullable();
            $table->decimal('monto_autorizado', 10)->nullable();
            $table->dateTime('fecha_autorizacion')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->string('numero_transferencia', 50)->nullable();

            $table->index(['id_estado_reintegro', 'fecha_solicitud'], 'idx_reintegros_estado_fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reintegros');
    }
};
