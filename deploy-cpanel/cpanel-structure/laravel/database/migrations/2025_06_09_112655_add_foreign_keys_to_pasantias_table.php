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
        Schema::table('pasantias', function (Blueprint $table) {
            $table->foreign(['id_escuela'], 'pasantias_ibfk_1')->references(['id_escuela'])->on('escuelas')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_alumno'], 'pasantias_ibfk_2')->references(['id_alumno'])->on('alumnos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_usuario_carga'], 'pasantias_ibfk_3')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasantias', function (Blueprint $table) {
            $table->dropForeign('pasantias_ibfk_1');
            $table->dropForeign('pasantias_ibfk_2');
            $table->dropForeign('pasantias_ibfk_3');
        });
    }
};
