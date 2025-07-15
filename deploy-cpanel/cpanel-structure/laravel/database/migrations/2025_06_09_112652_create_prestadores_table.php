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
        Schema::create('prestadores', function (Blueprint $table) {
            $table->integer('id_prestador', true);
            $table->string('nombre', 200)->index('idx_nombre');
            $table->boolean('es_sistema_emergencias')->nullable()->default(false)->index('idx_emergencias');
            $table->string('direccion', 300)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('especialidades', 500)->nullable();
            $table->boolean('activo')->nullable()->default(true)->index('idx_activo');
            $table->integer('id_tipo_prestador')->nullable()->index('fk_prestadores_tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestadores');
    }
};
