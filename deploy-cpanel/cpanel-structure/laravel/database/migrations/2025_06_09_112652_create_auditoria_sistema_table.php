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
        Schema::create('auditoria_sistema', function (Blueprint $table) {
            $table->integer('id_auditoria', true);
            $table->integer('id_usuario')->index('idx_usuario');
            $table->dateTime('fecha_hora')->nullable()->index('idx_fecha_hora');
            $table->string('accion', 100)->index('idx_accion');
            $table->string('tabla_afectada', 50)->nullable()->index('idx_tabla');
            $table->integer('id_registro')->nullable();
            $table->text('datos_anteriores')->nullable();
            $table->text('datos_nuevos')->nullable();
            $table->string('ip_usuario', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria_sistema');
    }
};
