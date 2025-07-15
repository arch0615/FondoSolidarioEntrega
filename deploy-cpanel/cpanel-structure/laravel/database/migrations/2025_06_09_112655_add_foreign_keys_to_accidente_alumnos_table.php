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
        Schema::table('accidente_alumnos', function (Blueprint $table) {
            $table->foreign(['id_accidente'], 'accidente_alumnos_ibfk_1')->references(['id_accidente'])->on('accidentes')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_alumno'], 'accidente_alumnos_ibfk_2')->references(['id_alumno'])->on('alumnos')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accidente_alumnos', function (Blueprint $table) {
            $table->dropForeign('accidente_alumnos_ibfk_1');
            $table->dropForeign('accidente_alumnos_ibfk_2');
        });
    }
};
