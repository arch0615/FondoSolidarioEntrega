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
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->integer('id_notificacion', true);
            $table->integer('id_usuario_destino')->index('idx_usuario_destino');
            $table->string('tipo_notificacion', 50)->index('idx_tipo');
            $table->string('titulo', 200);
            $table->text('mensaje')->nullable();
            $table->integer('id_entidad_referencia')->nullable();
            $table->string('tipo_entidad', 50)->nullable();
            $table->dateTime('fecha_creacion')->nullable()->useCurrent()->index('idx_fecha_creacion');
            $table->boolean('leida')->nullable()->default(false)->index('idx_leida');
            $table->dateTime('fecha_lectura')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
