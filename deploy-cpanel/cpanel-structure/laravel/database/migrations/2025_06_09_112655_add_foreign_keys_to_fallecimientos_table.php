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
        Schema::table('fallecimientos', function (Blueprint $table) {
            $table->foreign(['id_empleado'], 'fallecimientos_ibfk_1')->references(['id_empleado'])->on('empleados')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_usuario_carga'], 'fallecimientos_ibfk_2')->references(['id_usuario'])->on('usuarios')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fallecimientos', function (Blueprint $table) {
            $table->dropForeign('fallecimientos_ibfk_1');
            $table->dropForeign('fallecimientos_ibfk_2');
        });
    }
};
