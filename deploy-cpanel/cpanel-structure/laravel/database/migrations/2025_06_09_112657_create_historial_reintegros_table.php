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
        Schema::create('historial_reintegros', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_reintegro')->index('idx_historial_reintegro');
            $table->integer('id_usuario')->index('idx_historial_usuario');
            $table->dateTime('fecha_hora');
            $table->text('mensaje');
            $table->enum('accion', ['aceptar', 'rechazar', 'solicitar_informacion', 'mensaje', 'respuesta_escuela'])->index('idx_historial_accion');
            
            $table->foreign('id_reintegro')->references('id_reintegro')->on('reintegros')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            
            $table->index(['id_reintegro', 'fecha_hora'], 'idx_historial_reintegro_fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_reintegros');
    }
};
