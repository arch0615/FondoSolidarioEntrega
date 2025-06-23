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
        Schema::table('derivaciones', function (Blueprint $table) {
            $table->foreign(['id_accidente'], 'derivaciones_ibfk_1')->references(['id_accidente'])->on('accidentes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_prestador'], 'derivaciones_ibfk_2')->references(['id_prestador'])->on('prestadores')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_alumno'], 'derivaciones_ibfk_3')->references(['id_alumno'])->on('alumnos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('derivaciones', function (Blueprint $table) {
            $table->dropForeign('derivaciones_ibfk_1');
            $table->dropForeign('derivaciones_ibfk_2');
            $table->dropForeign('derivaciones_ibfk_3');
        });
    }
};
