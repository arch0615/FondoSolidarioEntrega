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
        Schema::table('salidas_educativas', function (Blueprint $table) {
            $table->foreign(['id_escuela'], 'salidas_educativas_ibfk_1')->references(['id_escuela'])->on('escuelas')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_usuario_carga'], 'salidas_educativas_ibfk_2')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salidas_educativas', function (Blueprint $table) {
            $table->dropForeign('salidas_educativas_ibfk_1');
            $table->dropForeign('salidas_educativas_ibfk_2');
        });
    }
};
