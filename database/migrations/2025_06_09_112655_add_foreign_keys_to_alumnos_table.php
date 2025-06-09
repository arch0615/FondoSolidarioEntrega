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
        Schema::table('alumnos', function (Blueprint $table) {
            $table->foreign(['id_escuela'], 'alumnos_ibfk_1')->references(['id_escuela'])->on('escuelas')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_seccion'], 'fk_alumnos_seccion')->references(['id_seccion'])->on('cat_secciones_alumnos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropForeign('alumnos_ibfk_1');
            $table->dropForeign('fk_alumnos_seccion');
        });
    }
};
