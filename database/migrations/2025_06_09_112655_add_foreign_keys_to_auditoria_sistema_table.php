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
        Schema::table('auditoria_sistema', function (Blueprint $table) {
            $table->foreign(['id_usuario'], 'auditoria_sistema_ibfk_1')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auditoria_sistema', function (Blueprint $table) {
            $table->dropForeign('auditoria_sistema_ibfk_1');
        });
    }
};
