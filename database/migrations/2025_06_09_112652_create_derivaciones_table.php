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
        Schema::create('derivaciones', function (Blueprint $table) {
            $table->integer('id_derivacion', true);
            $table->integer('id_accidente')->index('idx_accidente');
            $table->integer('id_prestador')->index('idx_prestador');
            $table->date('fecha_derivacion')->index('idx_fecha');
            $table->time('hora_derivacion')->nullable();
            $table->string('medico_deriva', 200)->nullable();
            $table->string('diagnostico_inicial', 500)->nullable();
            $table->string('acompa??ante', 200)->nullable();
            $table->text('observaciones')->nullable();
            $table->string('sello_escuela')->nullable();
            $table->string('firma_autorizada', 200)->nullable();
            $table->boolean('impresa')->nullable()->default(false);
            $table->dateTime('fecha_impresion')->nullable();

            $table->index(['fecha_derivacion', 'id_prestador'], 'idx_derivaciones_fecha_prestador');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('derivaciones');
    }
};
