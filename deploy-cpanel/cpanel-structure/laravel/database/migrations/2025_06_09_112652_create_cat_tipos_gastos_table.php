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
        Schema::create('cat_tipos_gastos', function (Blueprint $table) {
            $table->integer('id_tipo_gasto', true);
            $table->string('nombre_tipo_gasto', 100)->unique('uk_nombre_tipo_gasto');
            $table->string('descripcion', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_tipos_gastos');
    }
};
