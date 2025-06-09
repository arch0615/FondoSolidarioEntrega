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
        Schema::table('usuarios', function (Blueprint $table) {
            $table->foreign(['id_rol'], 'usuarios_ibfk_1')->references(['id_rol'])->on('roles')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_escuela'], 'usuarios_ibfk_2')->references(['id_escuela'])->on('escuelas')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign('usuarios_ibfk_1');
            $table->dropForeign('usuarios_ibfk_2');
        });
    }
};
