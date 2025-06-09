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
        Schema::create('cat_secciones_alumnos', function (Blueprint $table) {
            $table->integer('id_seccion', true);
            $table->string('nombre_seccion', 5)->unique('uk_nombre_seccion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_secciones_alumnos');
    }
};
