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
        Schema::create('cat_estados_solicitudes', function (Blueprint $table) {
            $table->integer('id_estado_solicitud', true);
            $table->string('nombre_estado', 50)->unique('uk_nombre_estado_sol');
            $table->string('descripcion', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_estados_solicitudes');
    }
};
