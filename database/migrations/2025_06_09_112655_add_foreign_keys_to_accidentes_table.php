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
        Schema::table('accidentes', function (Blueprint $table) {
            $table->foreign(['id_escuela'], 'accidentes_ibfk_1')->references(['id_escuela'])->on('escuelas')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_alumno'], 'accidentes_ibfk_2')->references(['id_alumno'])->on('alumnos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_usuario_carga'], 'accidentes_ibfk_3')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_estado_accidente'], 'fk_accidentes_estado')->references(['id_estado_accidente'])->on('cat_estados_accidentes')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accidentes', function (Blueprint $table) {
            $table->dropForeign('accidentes_ibfk_1');
            $table->dropForeign('accidentes_ibfk_2');
            $table->dropForeign('accidentes_ibfk_3');
            $table->dropForeign('fk_accidentes_estado');
        });
    }
};
