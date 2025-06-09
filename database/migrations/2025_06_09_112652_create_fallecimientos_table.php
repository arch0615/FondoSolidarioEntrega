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
        Schema::create('fallecimientos', function (Blueprint $table) {
            $table->integer('id_fallecimiento', true);
            $table->integer('id_empleado')->unique('uk_empleado');
            $table->date('fecha_fallecimiento')->index('idx_fecha_fallecimiento');
            $table->string('causa', 500)->nullable();
            $table->string('lugar_fallecimiento', 300)->nullable();
            $table->text('observaciones')->nullable();
            $table->integer('id_usuario_carga')->index('id_usuario_carga');
            $table->dateTime('fecha_carga')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fallecimientos');
    }
};
